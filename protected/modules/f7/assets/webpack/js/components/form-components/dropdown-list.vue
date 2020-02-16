<template>
  <div>
    <div class="form-group" v-if="element">
      <div class="col-sm-1"><i class="fa fa-align-justify handle"></i></div>
      <label class="col-sm-1 control-label">{{element.members[0].prop.value}}</label>
      <div class="col-sm-7">
        <select class="form-control m-b" name="account">
          <option>{{element.members[1].prop.text}}</option>
          <option
            v-for="(option, key) in element.members[1].prop['items']"
            :key="key"
          >{{option.text}}</option>
        </select>
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
                <input type="text" class="form-control" v-model="element.members[1].prop.hint" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Class</label>
              <div class="col-sm-10">
                <input
                  type="text"
                  class="form-control"
                  placeholder="space separated classes"
                  v-model="element.members[1].prop.css"
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
                  v-model="element.members[1].prop.style"
                />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Select Type</label>
              <div class="col-sm-10">
                <select class="m-b form-control" v-model="selectType">
                  <option label="Default" value="default">Default</option>
                  <option label="Model Mapping" value="modelMapping">Model Mapping</option>
                </select>
              </div>
            </div>
            <div class="form-group" v-if="selectType === 'modelMapping'">
              <label class="col-sm-2 control-label">Model Mapping</label>
              <div class="col-sm-10">
                <select class="m-b form-control" v-model="modelMapping">
                  <option label="Organizations" value="organization">Organizations</option>
                  <option label="How did you hear about us" value="heard">How Did you find about us</option>
                  <option label="Industries" value="industry">Industries</option>
                  <option label="Countries" value="country">Countries</option>
                  <option label="Cities" value="city">Cities</option>
                  <option label="Genders" value="Gender">Genders</option>
                </select>
              </div>
              <label class="col-sm-2 control-label">Enable Others</label>
              <div class="col-sm-10">
                <label class="checkbox-inline">
                  <input
                    type="checkbox"
                    id="inlineCheckbox1"
                    v-model="element.members[1].prop.others"
                  />
                </label>
              </div>
            </div>
            <div class="form-group" v-if="selectType === 'default'">
              <label class="col-sm-2 control-label">Model Mapping</label>
              <div class="col-sm-10">
                <div>
                  <input type="text" v-model="element.members[1].prop.text" placeholder="Label" />
                </div>
                <div v-for="(item, key) in element.members[1].prop.items" :key="key">
                  <input type="text" v-model="item.text" placeholder="Label" />
                  <div class="remove btn" title="Remove Element" @click="removeSelect(key)">×</div>
                </div>
                <br />
                <div class="btn btn-primary" @click="addSelect()">Add Options</div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Show During Export</label>
              <div class="col-sm-10">
                <label class="checkbox-inline">
                  <input
                    type="checkbox"
                    id="inlineCheckbox1"
                    v-model="showBackEnd"
                  />
                </label>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">CSV Label</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="element.members[1].prop.csv_label" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Validation Error Text</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="element.members[1].prop.error" />
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
  name: "dropdown-list",
  props: { element: Object, deleteComponent: Function, index: Number },
  mounted() {
    if(this.element.members[1].prop.name.split('-')[0] !== 'dropdownList') {
      this.selectType = 'modelMapping';
    }
  },
  watch: {
    selectType: async function(data) {
      if (data === "modelMapping") {
        this.element.members[1].prop.items = "";
        this.element.members[1].prop.model_mapping = {
          startup: "organization"
        };

        (this.modelMapping === 'organization') ? this.element.members[1].prop.name = 'startup' : this.element.members[1].prop.name = this.modelMapping.toLowerCase();
        this.element.members[1].prop.others = false;
        this.element.members[1].prop.text = (this.modelMapping === 'heard') ? 'How did you hear about the program?' : 'select your ' + this.modelMapping.toLowerCase();
      }
      if (data === "default") {
        delete this.element.members[1].prop.model_mapping;
        delete this.element.members[1].prop.others;
        this.element.members[1].prop.name = this.element.members[0].prop.for;
        this.element.members[1].prop.text = "Option 1";
        this.element.members[1].prop.items = [
          { text: "Option 2" },
          { text: "Option 3" }
        ];
      }
    },
    modelMapping: function(data) {
      if (data === "organization") {
        this.element.members[1].prop.name = 'startup';
        this.element.members[1].prop.model_mapping = { startup: data };
      } else {
        let keyData = data.toLowerCase();
        this.element.members[1].prop.name = keyData;
        this.element.members[1].prop.model_mapping = { [keyData]: data };
      }
      if(data === 'heard') {
        this.element.members[1].prop.text = 'How did you hear about the program?';
      } else {
        this.element.members[1].prop.text = 'select your ' + data.toLowerCase();
      }
    }
  },
  methods: {
    removeSelect: function(key) {
      this.element.members[1].prop.items.splice(key, 1);
    },
    addSelect: function() {
      let number = this.element.members[1].prop.items.length + 2;
      this.element.members[1].prop.items.push({ text: "Option " + number });
    }
  },
  data() {
    return {
      showOptions: false,
      selectType: "default",
      modelMapping: (this.element.members[1].prop.name.split('-')[1] === 'dropdownList') ? this.element.members[1].prop.name : "organization",
      options: [],
      defaultProp: this.element.members[1].prop
    };
  },
  computed: {
    requiredField: {
      get: function() {
        return this.element.members[1].prop.required ? true : false;
      },
      set: function(value) {
        if (value) {
          this.element.members[1].prop.required = 1;
          this.element.members[0].prop.required = 1;
        } else {
          this.element.members[1].prop.required = 0;
          this.element.members[0].prop.required = 0;
        }
      }
    },
    showBackEnd: {
      get: function() {
        return this.element.members[1].prop.showinbackendlist ? true : false;
      },
      set: function(value) {
        if (value) {
          this.element.members[1].prop.showinbackendlist = 1;
        } else {
          this.element.members[1].prop.showinbackendlist = 0;
        }
      }
    }
  }
};
</script>

