<template>
  <div>
    <div class="form-group" v-if="element">
      <div class="col-sm-1">
        <i class="fa fa-align-justify handle"></i>
      </div>
      <div class="col-sm-1"></div>
      <div class="col-sm-7">
        <h3 class="m-t-none m-b" v-if="element.prop.size === 3">{{element.prop.text}}</h3>
        <h2 class="m-t-none m-b" v-if="element.prop.size === 2">{{element.prop.text}}</h2>
        <h1 class="m-t-none m-b" v-if="element.prop.size === 1">{{element.prop.text}}</h1>
      </div>
      <div class="col-sm-3">
        <div
          class="btn btn-info"
          type="submit"
          data-toggle="modal"
          :data-target="'#'+element.name+element.sort"
        >Edit</div>
        <div class="btn btn-danger" @click="deleteComponent(index)">Delete</div>
      </div>
    </div>

    <div
      class="modal inmodal fade"
      :id="element.name+element.sort"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit {{element.name}}</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-2 control-label">Required</label>
              <div class="col-sm-10">
                <label class="checkbox-inline">
                  <input type="checkbox" id="inlineCheckbox1" v-model="requiredField" />
                </label>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Label</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="element.prop.text" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Type</label>
              <div class="col-sm-10">
                <select class="m-b form-control" type="number" v-model.number="element.prop.size">
                  <option label="h1" value="1">h1</option>
                  <option label="h2" value="2">h2</option>
                  <option label="h3" value="3">h3</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Class</label>
              <div class="col-sm-10">
                <input
                  type="text"
                  class="form-control"
                  placeholder="space separated classes"
                  v-model="element.prop.css"
                />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Style</label>
              <div class="col-sm-10">
                <input
                  type="text"
                  class="form-control"
                  placeholder="semicolon separated styles"
                  v-model="element.prop.style"
                />
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="btn btn-primary" data-dismiss="modal">Close</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "header-text",
  props: { element: Object, deleteComponent: Function, index: Number },
  mounted() {},
  computed: {
    requiredField: {
      get: function() {
        return this.element.prop.required ? true : false;
      },
      set: function(value) {
        if (value) {
          this.element.prop.required = 1;
        } else {
          this.element.prop.required = 0;
        }
      }
    }
  }
};
</script>

