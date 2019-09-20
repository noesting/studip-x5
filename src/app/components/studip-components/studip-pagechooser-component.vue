<template>
  <div class="pagechooser-wrapper">
    <div class="pagechooser">
      <button 
        type="pagechooser-button" 
        class="button" 
        :disabled="currentPage === 1 ? true : false"
        @click="pageDown"
      >Zurück</button>
      <span 
        type="pagechooser-pages">
        {{ currentPage }} von {{ maxPage }}
      </span>
      <button 
        type="pagechooser-button" 
        class="button" 
        :disabled="currentPage === maxPage ? true : false"
        @click="pageUp"
      >Weiter</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ['currentPage', 'maxPage'],
  methods: {
    pageUp(event) {
      this.$emit('page-up', event);
    },
    pageDown(event) {
      this.$emit('page-down', event);
    }
  }
};
</script>

<style lang="scss" scoped>
.pagechooser-wrapper {
    width: 100%;
    height: 100%;

    display: flex;
    flex-flow: row nowrap;

    background-color: #e7ebf1;

    border: 1px solid #1f3f70;
}

.pagechooser {
    width: 100%;

    display: flex;
    justify-content: space-between;
    align-items: baseline;

    padding-left: 0.5em;
}

.pagechooser-button {
    flex-grow: 1;
}

.pagechooser-page {
    flex-grow: 5;
}
</style>
