<template>
  <div>
    <div class="form-group" v-if="element">
      <div class="col-sm-1"><i class="fa fa-align-justify handle"></i></div>
      <label class="col-sm-1 control-label">{{element.members[0].prop.value}}</label>
      <div class="col-sm-7">
        <div class="rating-c">
          <label>
            <input type="radio" name="stars" value="1" />
            <span class="icon">★</span>
          </label>
          <label>
            <input type="radio" name="stars" value="2" />
            <span class="icon">★</span>
            <span class="icon">★</span>
          </label>
          <label>
            <input type="radio" name="stars" value="3" />
            <span class="icon">★</span>
            <span class="icon">★</span>
            <span class="icon">★</span>
          </label>
          <label>
            <input type="radio" name="stars" value="4" />
            <span class="icon">★</span>
            <span class="icon">★</span>
            <span class="icon">★</span>
            <span class="icon">★</span>
          </label>
          <label>
            <input type="radio" name="stars" value="5" />
            <span class="icon">★</span>
            <span class="icon">★</span>
            <span class="icon">★</span>
            <span class="icon">★</span>
            <span class="icon">★</span>
          </label>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="btn btn-info" type="submit" data-toggle="modal" :data-target="'#'+element.name+element.sort">Edit</div>
        <div class="btn btn-danger" @click="deleteComponent(index)">Delete</div>
      </div>
    </div>

    <div class="modal inmodal fade" :id="element.name+element.sort" tabindex="-1" role="dialog" aria-hidden="true">
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
                  <input type="checkbox" value="option1" id="inlineCheckbox1" v-model="requiredField"/>
                </label>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Label</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="element.members[0].prop.value"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Help Text</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="element.members[1].prop.hint"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Class</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="space separated classes" v-model="element.members[1].prop.css"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Style</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="semicolon separated styles" v-model="element.members[1].prop.style"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Value</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="element.members[1].prop.value"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Show During Export</label>
              <div class="col-sm-10">
                <label class="checkbox-inline">
                  <input type="checkbox" id="inlineCheckbox1" v-model="showBackEnd"/>
                </label>
              </div>
            </div>
             <div class="form-group">
              <label class="col-sm-2 control-label">CSV Label</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="element.members[1].prop.csv_label"/>
              </div>
            </div>
             <div class="form-group">
              <label class="col-sm-2 control-label">Validation Error Text</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" v-model="element.members[1].prop.error"/>
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
  name: "rating",
  props: { element: Object, deleteComponent: Function, index: Number },
  mounted() {},
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

<style scoped>
.rating-c {
  display: inline-block;
  position: relative;
  height: 50px;
  line-height: 50px;
  font-size: 50px;
}

.rating-c label {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  cursor: pointer;
}

.rating-c label:last-child {
  position: static;
}

.rating-c label:nth-child(1) {
  z-index: 5;
}

.rating-c label:nth-child(2) {
  z-index: 4;
}

.rating-c label:nth-child(3) {
  z-index: 3;
}

.rating-c label:nth-child(4) {
  z-index: 2;
}

.rating-c label:nth-child(5) {
  z-index: 1;
}

.rating-c label input {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
}

.rating-c label .icon {
  float: left;
  color: transparent;
}

.rating-c label:last-child .icon {
  color: #000;
}

.rating-c:not(:hover) label input:checked ~ .icon,
.rating-c:hover label:hover input ~ .icon {
  color: #09f;
}

.rating-c label input:focus:not(:checked) ~ .icon:last-child {
  color: #000;
  text-shadow: 0 0 5px #09f;
}
</style>