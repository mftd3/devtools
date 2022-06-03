import App from "./App.svelte";
import "./global.css";

const app = new App({ target: document.body, props: window.dd });

export default app;
