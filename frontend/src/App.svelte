<script>
  import DataField from "./inspector/DataField.svelte";

  let loaded = false;
  let dump = {};
  let objects = {};

  fetch("http://mf.test")
    .then((r) => r.json())
    .then((data) => {
      dump = data.dump;
      objects = data.objects;
      loaded = true;
    });
</script>

{#if loaded}
  <DataField obj={dump} {objects} />
{/if}

<style>
  :global(body) {
    margin: 0;
    font-size: 14px;
    font-family: "Roboto Mono", Menlo, Consolas, Monaco, Liberation Mono,
      Lucida Console, monospace;
    /* -webkit-font-smoothing: antialiased; */
  }
  :global(a) {
    text-decoration: none;
  }
</style>
