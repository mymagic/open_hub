<template>
  <div>
    <div class="form-group" v-if="element">
      <div class="col-sm-1">
        <i class="fa fa-align-justify handle"></i>
      </div>
      <div class="col-sm-7 col-sm-offset-1">
        <label>
          <input type="checkbox" name="optradio" checked />
          {{element.members[0].prop.text}}
        </label>
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
                  <input
                    type="checkbox"
                    value="option1"
                    id="inlineCheckbox1"
                    v-model="requiredField"
                  />
                </label>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Label</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="element.members[0].prop.value" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Help Text</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="element.members[0].prop.hint" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Class</label>
              <div class="col-sm-10">
                <input
                  type="text"
                  class="form-control"
                  placeholder="space separated classes"
                  v-model="element.members[0].prop.css"
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
                  v-model="element.members[0].prop.style"
                />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Value</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="element.members[0].prop.text" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Show During Export</label>
              <div class="col-sm-10">
                <label class="checkbox-inline">
                  <input type="checkbox" id="inlineCheckbox1" v-model="showBackEnd" />
                </label>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">CSV Label</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="element.members[0].prop.csv_label" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Validation Error Text</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="element.members[0].prop.error" />
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
  name: "check-box",
  props: { element: Object, deleteComponent: Function, index: Number },
  mounted() {},
  computed: {
    requiredField: {
      get: function() {
        return this.element.members[0].prop.required ? true : false;
      },
      set: function(value) {
        if (value) {
          this.element.members[0].prop.required = 1;
        } else {
          this.element.members[0].prop.required = 0;
        }
      }
    },
    showBackEnd: {
      get: function() {
        return this.element.members[0].prop.showinbackendlist ? true : false;
      },
      set: function(value) {
        if (value) {
          this.element.members[0].prop.showinbackendlist = 1;
        } else {
          this.element.members[0].prop.showinbackendlist = 0;
        }
      }
    }
  }
};
</script>

