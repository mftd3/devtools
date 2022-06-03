<script>
  export let obj;
  export let objects = {};
  export let depth = 1;

  let ref;

  if (obj.type === "object") {
    ref = objects[obj.value];
  }

  let opened = false;

  function toggle() {
    opened = !opened;
  }
</script>

<div class="wrapper">
  <div class="field" on:click={toggle}>
    {#if obj.type === "array"}
      {#if obj.length > 0}
        <span class="arrow" class:opened />
      {/if}
      <span class="key">{obj.key}</span>:
      {#if obj.length > 0}
        <span class="type">Array[{obj.length}]</span>
      {:else}
        <span class="type">[]</span>
      {/if}
    {:else if obj.type === "string"}
      <span class="key">{obj.key}</span>:
      <span class="value value-string">
        <span>"</span>{obj.value}<span>"</span>
      </span>
    {:else if obj.type === "object"}
      {#if !ref.system}
        <span class="arrow" class:opened />
      {/if}
      <span class="key">{obj.key}</span>:
      <a
        class="value value-class"
        href="vscode://file/{ref.file}"
        class:system={ref.system}
      >
        {ref.class}
      </a>
      <span class="additional">#{obj.value}</span>
    {:else}
      <span class="key">{obj.key}</span>:
      <span class="value value-{obj.type}">{obj.value}</span>
    {/if}
  </div>

  {#if opened}
    <div class="children" style="margin-left: {depth * 7}px">
      {#if obj.type === "array"}
        {#each obj.value as sub}
          <svelte:self obj={sub} depth={depth + 1} {objects} />
        {/each}
      {/if}

      {#if obj.type === "object"}
        {#each ref.properties as property}
          <svelte:self obj={property} depth={depth + 1} {objects} />
        {/each}
      {/if}
    </div>
  {/if}
</div>

<style>
  .field {
    color: #444;
    line-height: 20px;
    position: relative;
    padding-left: 14px;
  }
  .arrow {
    position: absolute;
    top: 7px;
    left: 0px;
    display: inline-block;
    border-top: 4px solid transparent;
    border-bottom: 4px solid transparent;
    border-left: 6px solid #2c3e50;
    transition: transform 0.1s ease;
  }
  .arrow.opened {
    transform: rotate(90deg);
  }
  .key {
    color: #8128e8;
  }
  .value-integer {
    color: rgb(0, 51, 204);
  }
  .value-boolean {
    color: #03c;
  }
  .value-string {
    color: #222;
  }
  .value-NULL {
    color: #999;
  }
  .value-class::before {
    content: "<";
    color: #ccc;
  }
  .value-class::after {
    content: ">";
    color: #ccc;
  }
  .value-class {
    color: #42b983;
  }
  .value-class.system {
    color: rgb(59, 130, 246);
  }
  .additional {
    color: rgb(107, 114, 128);
  }
</style>
