import { createApp } from 'vue';

// Create a new app instance to use as an event bus
const app = createApp({});
const eventBus = app.config.globalProperties.$eventBus = app;

export default eventBus;