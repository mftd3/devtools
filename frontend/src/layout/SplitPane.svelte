<script>
  export let collapsableLeft = false;
  export let collapsableRight = false;
</script>

<div class="wrapper">
  <div class="left" style:width="14%">1</div>
  <div class="right" style:width="86%">
    <slot name="right" />
  </div>
</div>

<style>
  .wrapper {
    width: 100%;
    display: flex;
    flex: 1 1 0%;
    height: 100%;
    overflow: hidden;
  }

  .left {
    height: 100%;
    border-right: 1px solid rgb(229, 231, 235);
  }
</style>
