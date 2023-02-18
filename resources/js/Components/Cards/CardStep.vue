<template>
  <div class="p-3 bg-white border-2 rounded-lg shadow-md">
    <h2 data-v-1aefe84e="" class="form-section__circle">
      <span data-v-1aefe84e="" class="form-section__title-container"
        ><span class="form-section__number"> {{ step }} </span><span class="form-section__name">{{ title }}</span></span
      >
    </h2>
    <div class="py-5">
      <slot />
    </div>
  </div>
</template>
<script>
export default {
  props: {
    step: Number,
    title: String,
  },
}
</script>
<style scoped>
.form-section__circle {
  font-family: NotoSans-Bold, sans-serif;
  font-size: 1.25rem;
  margin: -30px 0 0;
  display: flex;
  justify-content: space-between;
}
.form-section__number {
  border: 4px solid white;
  color: white;
  background-color: rgb(17, 17, 213);
  border-radius: 50%;
  margin: 0;
  position: absolute;
  font-family: NotoSans-Bold, sans-serif;
  font-size: 1.25rem;
  line-height: 36px;
  width: 46px;
  height: 46px;
  text-align: center;
}
.form-section__name {
  display: inline-block;
  margin-left: 50px;
  margin-top: 25px;
}

@media screen and (min-width: 768px) {
  .form-section__name {
    max-width: 98%;
  }
}
</style>
