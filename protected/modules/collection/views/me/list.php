<?php
Yii::app()->getClientScript()->registerScriptFile('https://cdn.jsdelivr.net/npm/vue-resource@1.5.1', CClientScript::POS_END); ?>
<div id="vue-collection-me-list">

<input type="hidden" v-model="activeItemId" value="<?php echo $id; ?>" />
<input type="hidden" v-model="urlGetCollections" value="<?php echo $this->createAbsoluteUrl('//collection/me/getCollections'); ?>" />
<input type="hidden" v-model="urlViewCollection" value="<?php echo $this->createAbsoluteUrl('//collection/me/view'); ?>" />
<input type="hidden" v-model="urlDeleteCollection" value="<?php echo $this->createAbsoluteUrl('//collection/me/deleteCollection'); ?>" />

<h1><?php echo $this->pageTitle; ?></h1>

<div class="row">
    <div class="col col-sm-3">
        <div id="collection-me-listing" class="list-group">
            <span v-for="collection of collections">
                <a class="list-group-item" href="#" data-id="{{ collection.id }}" v-on:click.stop="clickViewCollection" v-bind:class="[{active:activeItemId == collection.id }]">
                    <i class="fa fa-trash pull-right" v-on:click.stop="clickDeleteCollection" data-id="{{ collection.id }}"></i><?php echo Html::faIcon('fa fa-bookmark'); ?> {{ collection.title }}
                </a>
            </span>
        </div>
    </div>
    <div class="col col-sm-9">
        <template v-if="loading">
            <div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p class="margin-top-lg"><?php echo Yii::t('core', 'Loading...'); ?></p></div>
        </template>
        <div id="collection-list-viewPartial" v-html="htmlViewPartial"></div>
    </div>
</div>
</div>  

<?php Yii::app()->clientScript->registerScript('collection-me-list-vuejs', "
var vue = new Vue({
    el: '#vue-collection-me-list',
    data: {
        urlGetCollections:'', urlViewCollection:'',
        htmlViewPartial:'', activeItemId:'', loading:false, 
        collections:[]
    },
    ready() {
        this.getCollections();
    },
    methods:{
        getCollections: function(){
            this.loading = true;
            this.\$http.get(this.urlGetCollections).then(response => {
                this.loading = false;
                this.collections = response.data.data;
                if(this.activeItemId == '') this.activeItemId = this.collections[0].id;
                this.viewCollection();
            });
        },
        clickViewCollection: function(event){
            this.activeItemId = event.target.getAttribute('data-id');
            this.viewCollection();
        },
        viewCollection: function(){
            this.loading = true;
            this.htmlViewPartial = '';

            this.\$http.get(this.urlViewCollection+'?id='+this.activeItemId+'&viewMode=partial').then(response => {
                this.loading = false;
                this.htmlViewPartial = response.data;
            });
            event.preventDefault()
        },
        clickDeleteCollection: function(event){
            var jsonResult;
            var collectionId = parseInt(event.target.getAttribute('data-id'));
            var collectionTitle = '';

            this.\$http.get(this.urlDeleteCollection+'?id='+collectionId).then(response => {
                this.loading = false;
                jsonResult = response.data;
                if(jsonResult.status == 'success')
                {
                    for (var i = this.collections.length; i--;) {
                        if (this.collections[i].id == collectionId) {
                            collectionTitle = this.collections[i].title
                            this.collections.splice(i, 1);
                        }
                    }
                    toastr.success('Successfully removed collection: '+collectionTitle);

                    this.viewCollection();
                }
            });
            
        }
    }
});");
