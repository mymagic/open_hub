<template>
  <div>
    <div class="form-group" v-if="element">
      <div class="col-sm-1"><i class="fa fa-align-justify handle"></i></div>
      <div class="col-sm-4 col-sm-offset-1">
        <button class="btn btn-primary" type="submit">{{element.prop.name}}</button>
      </div>
      <div class="col-sm-3"></div>
      <div class="col-sm-3">
        <div class="btn btn-danger" @click="deleteComponent(index)">Delete</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "submit-button",
  props: { element: Object, deleteComponent: Function, index: Number },
  mounted() {}
};
</script>

