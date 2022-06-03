<script>
  import Icon from "./Icon.svelte";
  import LoadingIndicator from "./LoadingIndicator.svelte";

  export let iconLeft = "";
  export let iconRight = "";
  export let label = "";
  export let loading = false;
  export let loadingSecondary = false;
  export let type = "button";
  export let tag = "";
  export let disabled = false;

  $: component = $$props.href ? "a" : "button";
  $: ghost = disabled || loading || loadingSecondary;

  function handleClick() {
    alert(123);
  }
</script>

<svelte:element
  this={component}
  class="vue-ui-button"
  class:component
  class:disabled
  class:loading
  class:ghost
  v-bind="$attrs"
  {type}
  role="button"
  :aria-disabled="ghost"
  on:click|capture={handleClick}
>
  {#if loading}
    <LoadingIndicator />
  {/if}

  <span class="content">
    {#if loadingSecondary}
      <LoadingIndicator class="inline small loading-secondary" />
    {:else if iconLeft}
      <Icon icon="iconLeft" class="button-icon left" />
    {/if}

    <span class="default-slot">
      <slot>
        {{ label }}
      </slot>
    </span>

    <div v-if="tag != null" class="tag-wrapper">
      <div class="tag">{{ tag }}</div>
    </div>

    {#if iconRight}
      <Icon icon="iconRight" class="button-icon right" />
    {/if}
  </span>
</svelte:element>
