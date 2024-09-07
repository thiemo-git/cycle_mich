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
        <ion-button @click="takePhoto">Foto aufnehmen</ion-button>
        <img v-if="photo" :src="'data:image/jpeg;base64,' + photo" />
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

export default {
  name: 'Home',
  data() {
    return {
      photo: null, // Speichert das Base64-Foto
    };
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

        this.photo = image.base64String;
        console.log(image.base64String);
        alert(import.meta.env.VITE_OPENAI_KEY);

      } catch (error) {
        console.error('Error taking photo', error);
      }
    },
  },
};
</script>
