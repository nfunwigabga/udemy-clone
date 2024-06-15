import videojs from "video.js";
import { VideoPlayer } from "@videojs-player/vue";
import '@videojs/http-streaming';
import "video.js/dist/video-js.css";

export default defineNuxtPlugin((nuxtApp) => {
  nuxtApp.vueApp.component("VideoPlayer", VideoPlayer);
});