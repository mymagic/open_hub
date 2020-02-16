<template>
  <div class="row">
    <textarea
      type="hidden"
      id="Form_json_structure"
      name="Form[json_structure]"
      style="display:none;"
    >{{this.formStructure}}</textarea>
    <div class="col-md-12">
      <div class="btn-group" v-if="!this.loading && !this.viewJson">
        <button
          data-toggle="dropdown"
          class="btn btn-primary dropdown-toggle btn-block"
          aria-expanded="false"
        >
          Insert Component
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
          <li>
            <a @click="addComponent('inputText')">Input Text</a>
          </li>
          <li>
            <a @click="addComponent('dropdownList')">Select</a>
          </li>
          <li>
            <a @click="addComponent('textArea')">Text Area</a>
          </li>
          <li>
            <a @click="addComponent('submitButton')">Button</a>
          </li>
          <li>
            <a @click="addComponent('headerText')">Header</a>
          </li>
          <li>
            <a @click="addComponent('checkBox')">Checkbox Group</a>
          </li>
          <li>
            <a @click="addComponent('rating')">Rating Component</a>
          </li>
          <li>
            <a @click="addComponent('radioGroup')">Radio Group</a>
          </li>
          <li>
            <a @click="addComponent('fileUpload')">File Upload</a>
          </li>
          <li>
            <a @click="addJscript()">Action</a>
          </li>
        </ul>
      </div>
      <div class="btn-group" v-if="this.list && !this.loading">
        <div
          class="btn btn-primary dropdown-toggle btn-block"
          @click="toogle"
        >{{(this.viewJson) ? 'View Builder' : 'View JSON'}}</div>
      </div>
      <br />
      <br />
      <content-loader
        :height="160"
        :width="400"
        :speed="2"
        primaryColor="#f3f3f3"
        secondaryColor="#ecebeb"
        v-if="loading"
      >
        <circle cx="10" cy="20" r="8" />
        <rect x="25" y="15" rx="5" ry="5" width="220" height="10" />
        <circle cx="10" cy="50" r="8" />
        <rect x="25" y="45" rx="5" ry="5" width="220" height="10" />
        <circle cx="10" cy="80" r="8" />
        <rect x="25" y="75" rx="5" ry="5" width="220" height="10" />
        <circle cx="10" cy="110" r="8" />
        <rect x="25" y="105" rx="5" ry="5" width="220" height="10" />
      </content-loader>
      <codemirror :options="cmOptions" v-if="viewJson" v-model="stringCode"></codemirror>
      <div v-if="!viewJson">
        <draggable
          class="list-group"
          tag="ul"
          handle=".handle"
          v-model="list"
          v-bind="dragOptions"
          @start="drag = true"
          @end="drag = false"
        >
          <transition-group type="transition" :name="!drag ? 'flip-list' : null">
            <li
              class="list-group-item"
              v-for="(element, key) in list"
              :key="element.sort"
              style="background: white"
            >
              <component
                :is="element.name"
                :element="element"
                :index="key"
                :deleteComponent="deleteComp"
              ></component>
            </li>
          </transition-group>
        </draggable>
        <h3 v-if="jscript.length > 0">Actions</h3>
        <li
          class="list-group-item"
          v-for="(element, key) in jscript"
          :key="key"
          style="background: white"
        >
          <div class="form-group">
            <div class="col-sm-2">
              <select
                class="form-control m-b"
                name="Caller"
                v-model="element.caller"
                @change="checkBoxReset($event, key)"
              >
                <option disabled select>Caller</option>
                <option
                  v-for="(el, key) in list"
                  :key="key"
                  v-if="el.name === 'dropdownList' && el.members[1].prop.name.split('-')[0] === 'dropdownList' "
                  :value="el.members[1].prop.name"
                >{{el.members[0].prop.value}}</option>
                <option
                  v-for="(el, key) in list"
                  :key="key"
                  v-if="el.name === 'checkBox'"
                  :value="el.members[0].prop.name"
                >{{el.members[0].prop.text}}</option>
                <option
                  v-for="(el, key) in list"
                  :key="key"
                  v-if="el.name === 'radioGroup'"
                  :value="el.members[1].prop.name"
                >{{el.members[0].prop.value}}</option>
              </select>
            </div>
            <div class="col-sm-2">
              <select class="form-control m-b" name="Action" v-model="element.action">
                <option disabled selected>Action</option>
                <option value="show">show</option>
                <option value="hide">hide</option>
                <option value="enable">enable</option>
                <option value="disable">disable</option>
              </select>
            </div>
            <div class="col-sm-2">
              <select
                class="form-control m-b"
                name="Condition"
                v-model="element.con"
                @change="addKeyInJscript($event, key)"
              >
                <option disabled selected>Condition</option>
                <option value="check">check</option>
                <option value="select">select</option>
              </select>
            </div>
            <div
              class="col-sm-2"
              v-if="element.caller.split('-')[0] === 'dropdownList' || element.caller.split('-')[0] === 'radioGroup'"
            >
              <select
                class="form-control m-b"
                name="Sub Condition"
                v-for="(el, ekey) in list"
                :key="ekey"
                v-if="el.name === 'radioGroup' && el.members[1].prop.name === element.caller"
                @change="addSubCon($event, key)"
                v-model="element.subcon"
              >
                <option disabled selected>Sub Condition</option>
                <option v-for="(e, key) in el.members[1].prop.items" :key="key">{{e.text}}</option>
              </select>
              <select
                class="form-control m-b"
                name="Sub Condition"
                v-for="(el, ekey) in list"
                :key="ekey"
                v-if="el.name === 'dropdownList' && el.members[1].prop.name === element.caller"
                @change="addSubCon($event, key)"
                v-model="element.subcon"
              >
                <option disabled selected>Sub Condition</option>
                <option>{{el.members[1].prop.text}}</option>
                <option v-for="(e, key) in el.members[1].prop.items" :key="key">{{e.text}}</option>
              </select>
            </div>
            <div class="col-sm-2">
              <select class="form-control m-b" name="Targets" multiple v-model="element.items">
                <option
                  v-for="(el, key) in list"
                  :key="key"
                  v-if="el.name === 'inputText'"
                  :value="el.members[1].prop.name.split('-')[1]"
                >{{el.members[0].prop.value}}</option>
                <option
                  v-for="(el, key) in list"
                  :key="key"
                  v-if="el.name === 'radioGroup'"
                  :value="el.members[1].prop.name.split('-')[1]"
                >{{el.members[0].prop.value}}</option>
                <option
                  v-for="(el, key) in list"
                  :key="key"
                  v-if="el.name === 'rating'"
                  :value="el.members[1].prop.name.split('-')[1]"
                >{{el.members[0].prop.value}}</option>
                <option
                  v-for="(el, key) in list"
                  :key="key"
                  v-if="el.name === 'textArea'"
                  :value="el.members[1].prop.name.split('-')[1]"
                >{{el.members[0].prop.value}}</option>
                <option
                  v-for="(el, key) in list"
                  :key="key"
                  v-if="el.name === 'fileUpload'"
                  :value="el.members[1].prop.name.split('-')[1]"
                >{{el.members[0].prop.value}}</option>
              </select>
            </div>
            <div class="col-sm-2">
              <div class="btn btn-danger" @click="deleteAction(key)">Delete</div>
            </div>
          </div>
        </li>
      </div>
    </div>
  </div>
</template>

<script>
import draggable from "vuedraggable";
import inputText from "./form-components/input-text.vue";
import dropdownList from "./form-components/dropdown-list.vue";
import textArea from "./form-components/text-area.vue";
import submitButton from "./form-components/submit-button.vue";
import headerText from "./form-components/header-text.vue";
import checkBox from "./form-components/check-box.vue";
import rating from "./form-components/rating.vue";
import radioGroup from "./form-components/radio-group.vue";
import fileUpload from "./form-components/file-upload.vue";
import { ContentLoader } from "vue-content-loader";
import { codemirror } from "vue-codemirror";
import "codemirror/lib/codemirror.css";
import "codemirror/theme/monokai.css";
import "codemirror/mode/javascript/javascript.js";

export default {
  name: "json-form-structure",
  components: {
    draggable,
    inputText,
    dropdownList,
    textArea,
    submitButton,
    headerText,
    checkBox,
    rating,
    radioGroup,
    fileUpload,
    ContentLoader,
    codemirror
  },
  mounted() {
    let me = this;
    setTimeout(() => {
      me.formLoad();
      me.loading = false;
    }, 3000);
  },
  props: ["json"],
  watch: {
    jscript: {
      handler() {
        this.renderJsonJscript();
      },
      deep: true
    },
    list: {
      handler() {
        this.renderJson();
      },
      deep: true
    }
  },
  data() {
    return {
      formStructure: {
        form_type: "vertical",
        builder: "vue",
      },
      jscript: [],
      list: [],
      drawer: {
        inputText: {
          tag: "group",
          prop: {
            css: ""
          },
          members: [
            {
              tag: "label",
              prop: {
                required: 0,
                value: "Input Text"
              }
            },
            {
              tag: "textbox",
              prop: {
                style: "",
                css: "form-control",
                required: 0,
                showinbackendlist: 0,
                csv_label: "",
                hint: "",
                value: "",
                error: ""
              }
            }
          ]
        },
        dropdownList: {
          tag: "group",
          prop: {
            css: ""
          },
          members: [
            {
              tag: "label",
              prop: {
                required: 0,
                value: "List"
              }
            },
            {
              tag: "list",
              prop: {
                css: "form-control",
                style: "",
                required: 0,
                showinbackendlist: 0,
                csv_label: "",
                hint: "",
                value: "",
                error: "",
                text: "Option 1",
                items: [
                  {
                    text: "Option 2"
                  },
                  {
                    text: "Option 3"
                  }
                ]
              }
            }
          ]
        },
        textArea: {
          tag: "group",
          prop: {
            css: ""
          },
          members: [
            {
              tag: "label",
              prop: {
                required: 0,
                value: "Text Area"
              }
            },
            {
              tag: "textarea",
              prop: {
                css: "form-control",
                style: "",
                required: 0,
                showinbackendlist: 0,
                csv_label: "",
                hint: "",
                value: "",
                error: ""
              }
            }
          ]
        },
        submitButton: {
          tag: "button",
          prop: {
            css1: "",
            css2: "",
            name: "Submit",
            items: [
              {
                name: "save",
                value: "Draft",
                css: "btn-warning"
              },
              {
                name: "save",
                value: "Submit",
                css: "btn-primary"
              }
            ]
          }
        },
        headerText: {
          tag: "headline",
          prop: {
            css: "",
            style: "",
            required: 0,
            size: 1,
            text: "Header Text"
          }
        },
        checkBox: {
          tag: "group",
          prop: {
            css: ""
          },
          members: [
            {
              tag: "checkbox",
              prop: {
                css: "",
                style: "",
                required: 0,
                isgroup: 0,
                showinbackendlist: 0,
                csv_label: "",
                checked: 1,
                hint: "",
                value: "",
                error: "",
                text: "Option 1"
              }
            }
          ]
        },
        rating: {
          tag: "group",
          prop: {
            css: ""
          },
          members: [
            {
              tag: "label",
              prop: {
                required: 0,
                value: "Rating Component"
              }
            },
            {
              tag: "rating",
              prop: {
                style: "",
                css: "form-control",
                required: 0,
                showinbackendlist: 0,
                csv_label: "",
                hint: "",
                value: "",
                error: ""
              }
            }
          ]
        },
        radioGroup: {
          tag: "group",
          prop: {
            css: ""
          },
          members: [
            {
              tag: "label",
              prop: {
                required: 0,
                value: "Radio Group"
              }
            },
            {
              tag: "radio",
              prop: {
                css: "",
                style: "",
                required: 0,
                other: 0,
                showinbackendlist: 0,
                csv_label: "",
                hint: "",
                value: "",
                error: "",
                text: "",
                items: [
                  {
                    text: "Option 1",
                    checked: "true"
                  },
                  {
                    text: "Option 2",
                    checked: "false"
                  },
                  {
                    text: "Option 3",
                    checked: "false"
                  }
                ]
              }
            }
          ]
        },
        fileUpload: {
          tag: "group",
          prop: {
            css: ""
          },
          members: [
            {
              tag: "label",
              prop: {
                required: 0,
                value: "File Upload"
              }
            },
            {
              tag: "upload",
              prop: {
                css: "form-control",
                style: "",
                required: 0,
                showinbackendlist: 0,
                csv_label: "",
                hint: "",
                value: "",
                error: ""
              }
            }
          ]
        }
      },
      drag: false,
      viewJson: false,
      loading: true,
      cmOptions: {
        tabSize: 4,
        mode: {
          name: "javascript",
          json: true
        },
        lineNumbers: true,
        line: true,
        theme: "monokai",
        readOnly: 'nocursor'
      }
    };
  },
  computed: {
    stringCode: {
      get: function() {
        return JSON.stringify(this.formStructure, null, 2);
      },
      set: function(newValue) {
        this.formStructure = JSON.parse(JSON.stringify(newValue));
      }
    },
    dragOptions() {
      return {
        animation: 200,
        group: "description",
        disabled: false,
        ghostClass: "ghost"
      };
    }
  },
  methods: {
    toogle() {
      this.viewJson = !this.viewJson;
    },
    renderJson: async function() {
      let me = this;
      this.formStructure = {
        form_type: "vertical",
        builder: "vue",
      };
      await this.list.forEach((data, key) => {
        data.sort = key;
        me.formStructure[key] = JSON.parse(JSON.stringify(data));
      });
      await this.renderJsonJscript();
    },
    renderJsonJscript: async function() {
      let me = this;
      this.formStructure["jscript"] = [];
      await this.jscript.forEach((data, key) => {
        me.formStructure["jscript"][key] = data;
      });
    },
    checkBoxReset: function(event, key) {
      if (event.target.value.split("-")[0] === "checkBox") {
        let result = Object.keys(
          Object.assign({}, this.jscript[key].condition)
        );
        if (result.length > 0) {
          this.jscript[key].condition[result[0]] = "";
        } else {
          this.jscript[key].condition = new Object();
        }
      }
    },
    addKeyInJscript: function(event, key) {
      this.jscript[key].condition = { [event.target.value]: "" };
    },
    addSubCon: function(event, key) {
      let result = Object.keys(Object.assign({}, this.jscript[key].condition));
      if (result.length > 0) {
        this.jscript[key].condition[result[0]] = event.target.value;
      }
    },
    deleteAction: function(key) {
      this.jscript.splice(key, 1);
    },
    addJscript: function() {
      this.jscript.push({
        caller: "",
        action: "",
        items: [],
        con: "",
        subcon: "",
        condition: {}
      });
    },
    addComponent: function(key) {
      let component = JSON.parse(JSON.stringify(this.drawer[key]));
      component.sort = this.list.length;
      if (
        key !== "submitButton" &&
        key !== "headerText" &&
        key !== "checkBox"
      ) {
        let randomNumber = this.LeftPadWithZeros(
          Math.floor(100000000 + Math.random() * 900000000),
          9
        );
        component.members[0].prop.for = key + "-" + randomNumber;
        if (key === "fileUpload") {
          component.members[1].prop.name = "uploadfile";
        } else {
          component.members[1].prop.name = key + "-" + randomNumber;
        }
      }
      if (key === "checkBox") {
        let randomNumber = this.LeftPadWithZeros(
          Math.floor(100000000 + Math.random() * 900000000),
          9
        );
        component.members[0].prop.name = key + "-" + randomNumber;
      }
      component.name = key;
      this.list.push(component);
      return true;
    },
    deleteComp: function(key) {
      this.list.splice(key, 1);
    },
    LeftPadWithZeros: function(number, length) {
      var str = "" + number;
      while (str.length < length) {
        str = "0" + str;
      }
      return str;
    },
    formLoad: function() {
      if (this.json) {
        this.formStructure = JSON.parse(JSON.stringify(this.json));
        let structure = JSON.parse(JSON.stringify(this.json));
        if (structure["jscript"]) {
          this.jscript = JSON.parse(JSON.stringify(structure["jscript"]));
        }
        delete structure.jscript;
        delete structure.form_type;
        let me = this;

        Object.keys(structure).forEach(key => {
          me.list.push(JSON.parse(JSON.stringify(structure[key])));
        });
      }
    }
  }
};
</script>

<style>
.button {
  margin-top: 35px;
}

.flip-list-move {
  transition: transform 0.5s;
}

.no-move {
  transition: transform 0s;
}

.ghost {
  opacity: 0.5;
  background: #c8ebfb;
}

.list-group {
  min-height: 20px;
}

.list-group-item {
  cursor: move;
}

.list-group-item i {
  cursor: pointer;
}
</style>