<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-title>Chatbot</ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title size="large">Tab 1</ion-title>
        </ion-toolbar>
      </ion-header>


      <div id="container">
        <div>
          <ion-button @click="takePhoto">Foto aufnehmen</ion-button>
        </div>
        <div>
          <img v-if="photo" :src="photo" />
        </div>

        <p v-if="loading">Bitte warten !!!</p>
        <p v-if="message" v-html="formattedMessage"></p>

      </div>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">

import { IonPage, IonHeader, IonToolbar, IonTitle, IonContent } from '@ionic/vue';
import ExploreContainer from '@/components/ExploreContainer.vue';
</script>

<script  lang="ts">
import { Camera, CameraResultType, CameraSource } from '@capacitor/camera';
import OpenAI from "openai";

export default {
  name: 'Home',
  data() {
    return {
      loading: false,
      photo: null,
      message: null,
    };
  },
  computed: {
    formattedMessage() {
      // \n durch <br> ersetzen
      return this.message.replace(/\n/g, '<br>');
    }
  },
  methods: {
    async takePhoto() {
      try {
        const image = await Camera.getPhoto({
          quality: 90,
          allowEditing: false,
          resultType: CameraResultType.Base64,
          source: CameraSource.Camera,
        });



        const img = new Image();
        img.src = "data:image/jpeg;base64,"+image.base64String;

        const target=this;
        target.loading=true;

        img.onload = () => {
          console.log("hier");
          const canvas = document.createElement('canvas');
          const ctx = canvas.getContext('2d');
          const width = 450; // Zielbreite
          const scaleFactor = width / img.width;
          const height = img.height * scaleFactor;

          canvas.width = width;
          canvas.height = height;

          ctx.drawImage(img, 0, 0, width, height);
          //console.log(canvas.toDataURL());

          const data_url = canvas.toDataURL();

          target.photo = data_url;

          (async () => {
            const openai = new OpenAI({dangerouslyAllowBrowser:true, apiKey: import.meta.env.VITE_OPENAI_KEY});
            const response = await openai.chat.completions.create({
              model: "gpt-4o-mini",
              messages: [
                {
                  role: "user",
                  content: [
                    {
                      type: "text",
                      text: "You are MMM - Mannheim Müll Mentor, a friendly, humorous, and approachable waste advisor. You help users from Mannheim and beyond with waste reduction, correct disposal, donation, reuse, and upcycling tips. The user gives you an image and wants to know how and where the item can be recycled, into which waste it has to be put, where to sell it or how to reuse it. You respond in a lighthearted and engaging manner, ensuring that the advice is practical and not overly technical. Avoid getting lost in details, and keep the focus on simple, actionable tips. References to Mannheim and its culture are welcome, adding a local touch to the advice. Always prioritize friendliness and humor, and be quick to offer helpful suggestions. Add a few emojis to make it more fun! \n" +
                          "Please always answer in German !"
                    },
                    {
                      type: "image_url",
                      image_url: {
                        "url": data_url,
                      },
                    },
                  ],
                },
              ],
            });

            target.message = response.choices[0].message.content.replaceAll("\n","<br>");
            target.loading=false;

          })();


        };



        //console.log(image.base64String);
        //alert(import.meta.env.VITE_OPENAI_KEY);

      } catch (error) {
        console.error('Error taking photo', error);
      }
    },
  },
};
</script>
