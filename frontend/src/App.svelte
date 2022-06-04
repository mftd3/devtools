<script>
  import DataField from "./inspector/DataField.svelte";
  import StateInspector from "./inspector/StateInspector.svelte";
  import StateType from "./inspector/StateType.svelte";
  import SplitPane from "./layout/SplitPane.svelte";

  let dump = {};
  let objects = {};
  let loaded = false;

  fetch("http://localhost:8080")
    .then((r) => r.json())
    .then((d) => {
      console.log(d);
      dump = d.dump;
      objects = d.objects;
      console.log(objects);
      loaded = true;
    });
</script>

{#if loaded}
  <div class="wrapper">
    <SplitPane>
      <div slot="left">123</div>
      <StateInspector slot="right">
        <StateType>
          <DataField obj={dump} {objects} />
        </StateType>
      </StateInspector>
    </SplitPane>
  </div>
{/if}

<style>
  .wrapper {
    height: 400px;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    border-top: 1px solid #ccc;
  }
</style>
