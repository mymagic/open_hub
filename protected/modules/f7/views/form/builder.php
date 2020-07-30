<script>
  $( function() {
    
    $("#reset-form").click(function(){
      $("#sortable").children().remove();
    });

    $("#get-json").click(function(){

        var result='{"form_type":"vertical",';
          
        var actions = '"jscripts":[';
        var hasAction = false;
        $('[data-type]').each(function(key, value){
           if (value.id.startsWith('action-'))
              {
                hasAction = true;
                actions = actions + getConvertedControlToJson(key, value);
              }
           else
              result = result + getConvertedControlToJson(key, value);
         });
         
         actions = actions + ']';
         actions = actions.replace("},]","}]");
         if(hasAction)
            result = result + actions;
         result = result + '}';
         result = result.replace("},}","}}");
         
         $("#result").val(result);
    });

    $( "#sortable" ).sortable({
      revert: true,
      // receive: function( event, ui ) {
      //   if(ui.item[0].id == 'draggable')
      //   {
      //     console.log(ui);
      //   }
      // }
    });

    $( ".ui-state-highlight" ).draggable({
      connectToSortable: "#sortable",
      helper: "clone",
      revert: "invalid"
    });

    $(".ui-state-highlight").dblclick(function(event){

      //todo

      if (event.target.id == 'input-text')
      {
          var time = (new Date).getTime();
          var id = 'control-' + time;
          var sId = 'input-setting-' + time;
          var aIdEdit = 'edt_frm-'+ time;
          var aIdDel = 'del_frm-'+ time;
          var blockId = 'block-' + time;

          var settingsHtml = getHtmlSettingsForInputText(time);
          var divActionButtons = getHtmlActionButtons(aIdDel, aIdEdit);
          var htmlTag = getHtmlTagForInputText(sId, settingsHtml, blockId, divActionButtons, id);

          $( "#sortable" ).append(htmlTag);
      }

    });

  $( "#sortable" ).droppable({
  drop: function( event, ui ) {
    ui.draggable.removeClass("ui-state-highlight mmf");
    ui.draggable.addClass("c-control");

    var time = (new Date).getTime();
    
    var sId = 'input-setting-' + time;
    var aIdEdit = 'edt_frm-'+ time;
    var aIdDel = 'del_frm-'+ time;
    var blockId = 'block-' + time;

    if (ui.helper.text() == 'Input Text')
    {
      var id = 'inputtext-' + time;
      prepareInputText(ui, time, id, sId, aIdEdit, aIdDel, blockId);
    }
    else if (ui.helper.text() == 'Select')
    {
      var id = 'select-' + time;
      prepareSelect(ui, time, id, sId, aIdEdit, aIdDel, blockId);
    }
    else if (ui.helper.text() == 'Text Area')
    {
      var id = 'textarea-' + time;
      prepareAreaText(ui, time, id, sId, aIdEdit, aIdDel, blockId);
    }
    else if (ui.helper.text() == 'Button')
    {
      var id = 'button-' + time;
      prepareButton(ui, time, id, sId, aIdEdit, aIdDel, blockId);
    }
    else if (ui.helper.text() == 'Header')
    {
      var id = 'header-' + time;
      prepareHeader(ui, time, id, sId, aIdEdit, aIdDel, blockId);
    }
    else if (ui.helper.text() == 'File Upload')
    {
      var id = 'fileupload-' + time;
      prepareFileUpload(ui, time, id, sId, aIdEdit, aIdDel, blockId);
    }
    else if (ui.helper.text() == 'Radio Group')
    {
      var id = 'radiogroup-' + time;
      prepareRadioGroup(ui, time, id, sId, aIdEdit, aIdDel, blockId);
    }
    else if (ui.helper.text() == 'Checkbox Group')
    {
      var id = 'checkboxgroup-' + time;
      prepareCheckBoxGroup(ui, time, id, sId, aIdEdit, aIdDel, blockId);
    }
    else if (ui.helper.text() == 'Action')
    {
      var id = 'action-' + time;
      prepareAction(ui, time, id, sId, aIdEdit, aIdDel, blockId);
    }
    else if (ui.helper.text() == 'Rating Component')
    {
      var id = 'ratingcomponent-' + time;
      prepareRatingComponent(ui, time, id, sId, aIdEdit, aIdDel, blockId);
    }
  }
 });

  function prepareInputText(ui, time, id, sId, aIdEdit, aIdDel, blockId)
  {
    var settingsHtml = getHtmlSettingsForInputText(time);

    var divActionButtons = getHtmlActionButtons(aIdDel, aIdEdit);

    ui.draggable.html(getHtmlTagForInputText(sId, settingsHtml, blockId, divActionButtons, id));

    //Events
    getEventsForInputText(time, aIdEdit, blockId, sId, aIdDel);
  }

  function getHtmlTagForInputText(sId, settingsHtml, blockId, divActionButtons, id)
  {
    return '<div>' +
        '<div id="'+ sId +'"style="display: none;">' +
        settingsHtml +
        '</div>' +
        '<div id="' + blockId + '">' +
            divActionButtons +
            '<div class="form-group">' +
              '<label for="'+ id +'">Input Text:</label>' +
              '<input data-type="inputtext" type="text" class="form-control" id="' + id + '">'+
            '</div>'+
        '</div>' +
      '</div>'
  }

  function prepareSelect(ui, time, id, sId, aIdEdit, aIdDel, blockId)
  {
    var settingsHtml = getHtmlSettingsForSelect(time);

    var divActionButtons = getHtmlActionButtons(aIdDel, aIdEdit);

    ui.draggable.html(
      '<div>' +
        '<div id="'+ sId +'"style="display: none;">' +
        settingsHtml +
        '</div>' +
        '<div id="' + blockId + '">' +
            divActionButtons +
            '<div class="form-group">' +
              '<label for="'+ id +'">Select list:</label>' +
              '<select data-type="select" class="form-control" id="'+ id +'">' +
              '<option>Option 1</option>' +
              '<option>Option 2</option>' +
              '<option>Option 3</option>' +
              '</select>' +
            '</div>'+
        '</div>' +
      '</div>');

    //Events
    getEventsForSelect(time, aIdEdit, blockId, sId, aIdDel);
  }

  function prepareAreaText(ui, time, id, sId, aIdEdit, aIdDel, blockId)
  {
    var settingsHtml = getHtmlSettingsForAreaText(time);

    var divActionButtons = getHtmlActionButtons(aIdDel, aIdEdit);

    ui.draggable.html(
      '<div>' +
        '<div id="'+ sId +'"style="display: none;">' +
        settingsHtml +
        '</div>' +
        '<div id="' + blockId + '">' +
            divActionButtons +
            '<div class="form-group">' +
              '<label for="'+ id +'">Text Area:</label>' +
              '<textarea data-type="textarea" class="form-control" rows="5" id="' + id +'"></textarea>'+
            '</div>'+
        '</div>' +
      '</div>');

    //Events
    getEventsForAreaText(time, aIdEdit, blockId, sId, aIdDel);
  }

  function prepareButton(ui, time, id, sId, aIdEdit, aIdDel, blockId)
  {
    var settingsHtml = getHtmlSettingsForButton(time);

    var divActionButtons = getHtmlActionButtons(aIdDel, aIdEdit);

    ui.draggable.html(
      '<div>' +
        '<div id="'+ sId +'"style="display: none;">' +
        settingsHtml +
        '</div>' +
        '<div id="' + blockId + '">' +
            divActionButtons +
            '<div class="form-group">' +
              '<button id="' + id + '" type="button" data-type="button" class="btn btn-success">Button</button>'+
            '</div>'+
        '</div>' +
      '</div>');

    //Events
    getEventsForButton(time, aIdEdit, blockId, sId, aIdDel);
  }

  function prepareHeader(ui, time, id, sId, aIdEdit, aIdDel, blockId)
  {
    var settingsHtml = getHtmlSettingsForHeader(time);

    var divActionButtons = getHtmlActionButtons(aIdDel, aIdEdit);

    ui.draggable.html(
      '<div>' +
        '<div id="'+ sId +'"style="display: none;">' +
        settingsHtml +
        '</div>' +
        '<div id="' + blockId + '">' +
            divActionButtons +
            '<div class="form-group">' +
            '<h2 class="" data-type="header" id="header-'+ time +'">Header</h2>' +
            '</div>'+
        '</div>' +
      '</div>');

    //Events
    getEventsForHeader(time, aIdEdit, blockId, sId, aIdDel);
  }

  function prepareFileUpload(ui, time, id, sId, aIdEdit, aIdDel, blockId)
  {
    var settingsHtml = getHtmlSettingsForFileUpload(time);

    var divActionButtons = getHtmlActionButtons(aIdDel, aIdEdit);

    ui.draggable.html(
      '<div>' +
        '<div id="'+ sId +'"style="display: none;">' +
        settingsHtml +
        '</div>' +
        '<div id="' + blockId + '">' +
            divActionButtons +
            '<div class="form-group">' +
            '<label for="'+ id +'" class="field-label">File Upload</label>' +
            '<input type="file" data-type="upload" class="form-control" id="upload-'+ time +'">' +
            '</div>'+
        '</div>' +
      '</div>');

    //Events
    getEventsForFileUpload(time, aIdEdit, blockId, sId, aIdDel);
  }

  function prepareRadioGroup(ui, time, id, sId, aIdEdit, aIdDel, blockId)
  {
    var settingsHtml = getHtmlSettingsForRadioGroup(time);

    var divActionButtons = getHtmlActionButtons(aIdDel, aIdEdit);

    ui.draggable.html(
      '<div>' +
        '<div id="'+ sId +'"style="display: none;">' +
        settingsHtml +
        '</div>' +
        '<div id="' + blockId + '">' +
            divActionButtons +
            '<div class="form-group">' +
              '<label for="control-'+ time +'" class="">Radio Group</label>' +
              '<div data-type="radiogroup" id="' + id + '" class="radio-group">'+
                '<div class="radio">'+
                  '<input name="control-'+ time +'" class="selectives" id="control-'+ time +'-0" value="option-1" type="radio">' +
                  '<label for="control-'+ time +'-0">Option 1</label>' +
                '</div>' +
                '<div class="radio">' +
                  '<input name="control-'+ time +'" class="selectives" id="control-'+ time +'-1" value="option-2" type="radio">' +
                  '<label for="control-'+ time +'-1">Option 2</label>' +
                '</div>' +
                '<div class="radio">' +
                  '<input name="control-'+ time +'" class="selectives" id="control-'+ time +'-2" value="option-3" type="radio">' +
                  '<label for="control-'+ time +'-2">Option 3</label>' +
                '</div>' +
              '</div>' +
            '</div>'+
        '</div>' +
      '</div>');

    //Events
    getEventsForRadioGroup(time, aIdEdit, blockId, sId, aIdDel);
  }

  function prepareCheckBoxGroup(ui, time, id, sId, aIdEdit, aIdDel, blockId)
  {
    var settingsHtml = getHtmlSettingsForCheckBoxGroup(time);

    var divActionButtons = getHtmlActionButtons(aIdDel, aIdEdit);

    ui.draggable.html(
      '<div>' +
        '<div id="'+ sId +'"style="display: none;">' +
        settingsHtml +
        '</div>' +
        '<div id="' + blockId + '">' +
            divActionButtons +
            '<div class="form-group">' +
              '<label for="control-'+ time +'" class="fb-control-label">Checkbox Group</label>' +
              '<div data-type="checkboxgroup" id="'+ id +'" class="control-' + time + '">' +
                '<div id="checkbox-'+ time +'" class="checkbox">' +
                  '<input name="control-'+ time +'-0" class="selectives" id="control-'+ time +'-0" value="option-1" type="checkbox" checked="checked">' +
                  '<label for="control-'+ time +'-0">Option 1</label>' +
                '</div>' +
              '</div>' +
            '</div>'+
        '</div>' +
      '</div>');

    //Events
    getEventsForCheckBoxGroup(time, aIdEdit, blockId, sId, aIdDel);
  }

  function prepareAction(ui, time, id, sId, aIdEdit, aIdDel, blockId)
  {
    var settingsHtml = getHtmlSettingsForAction(time);

    var divActionButtons = getHtmlActionButtons(aIdDel, aIdEdit);

    ui.draggable.html(
      '<div>' +
        '<div id="'+ sId +'"style="display: none;">' +
        settingsHtml +
        '</div>' +
        '<div id="' + blockId + '">' +
            divActionButtons +
            '<div class="form-group">' +
            '<label data-type="action" id="action-'+ time +'" class="field-label">Action</label>' +
            '</div>'+
        '</div>' +
      '</div>');

    //Events
    getEventsForAction(time, aIdEdit, blockId, sId, aIdDel);
  }

  function prepareRatingComponent(ui, time, id, sId, aIdEdit, aIdDel, blockId, labelLow='Strongly Disagree', labelHigh='Strongly Agree')
  {
    var settingsHtml = getHtmlSettingsForRatingComponent(time);

    var divActionButtons = getHtmlActionButtons(aIdDel, aIdEdit);

    ui.draggable.html(
      '<div>' +
        '<div id="'+ sId +'"style="display: none;">' +
        settingsHtml +
        '</div>' +
        '<div id="' + blockId + '">' +
            divActionButtons +
            '<div class="form-group">' +
              '<label for="'+ id +'">Rating Component:</label>' +
              '<br /><br />' +
              '<div class="container">' +
              '<div style="width:600px" data-type="rating" id="rating-'+ time +'" class="row">' +
                  '<div id="1-'+ time +'" class="rating col-xs-1 col-sm-2 col-md-2">1</div>' +
                  '<div id="2-'+ time +'" class="rating col-xs-1 col-sm-2 col-md-2">2</div>' +
                  '<div id="3-'+ time +'" class="rating col-xs-1 col-sm-2 col-md-2">3</div>' +
                  '<div id="4-'+ time +'" class="rating col-xs-1 col-sm-2 col-md-2">4</div>' +
                  '<div id="5-'+ time +'" style="border-right-width:1.5px;" class="rating col-xs-1 col-sm-2 col-md-2">5</div>'+
              '</div>' +
              '<div class="row">' +
                '<div class="col-xs-4 nopadding"><small>'+labelLow+'</small></div>' +
                '<div class="col-xs-3 text-right"><small>'+labelHigh+'</small></div>'+
              '</div>'+
            '<input type="hidden" id="voted-'+ time +'" name="voted-'+ time +'" value="">' +
        '</div>'+
            '</div>'+
        '</div>' +
      '</div>' 
     );
    
    //Events
    getEventsForRatingComponent(time, aIdEdit, blockId, sId, aIdDel);
  }

});


// Start: EVENT Functions
function getEventsForInputText(time, aIdEdit, blockId, sId, aIdDel)
{
  $("#" + aIdEdit).click(function() {
    $("#" + blockId).slideUp( "slow" );
    $("#" + sId).slideDown( "slow" );
  });

  $("#" + aIdDel).click(function(){
    $("#" + blockId).closest( "li" ).remove();
  });

  $("#" + sId).find('.close-settings').click(function(){
    $("#" + sId).slideUp( "slow" );
    $("#" + blockId).slideDown( "slow" );

    var sLabelValue = $("#label-" + time).val();
    $("label[for='inputtext-"+ time +"']").text(sLabelValue);
  });
}

function getEventsForSelect(time, aIdEdit, blockId, sId, aIdDel)
{
  $("#" + aIdEdit).click(function() {
    $("#" + blockId).slideUp( "slow" );
    $("#" + sId).slideDown( "slow" );
  });


  $("#" + aIdDel).click(function(){
    $("#" + blockId).closest( "li" ).remove();
  });

  $("#" + sId).find('.close-settings').click(function(){
    $("#" + sId).slideUp( "slow" );
    $("#" + blockId).slideDown( "slow" );

    var sLabelValue = $("#label-" + time).val();
    $("label[for='select-"+ time +"']").text(sLabelValue);

    $("#select-" + time).children().remove();

    var flag = false;

    $(':input[name="selected-' + time + '-option"]').each(function(index){
      
      if ($(this).is( ":radio" ) && $(this).is(':checked'))
      {
        flag = true;
      }
      else if(!$(this).is( ":radio" ))
      {
          if (flag == true)
          {
            $("#select-" + time).append('<option selected="selected">'+ $(this).val() +'</option>');
            flag = false;
          }
          else if ($(this).val() != 'false')
          {
            $("#select-" + time).append('<option>'+ $(this).val() +'</option>');
            
          }
      }

    });

  });
  // Add option
  $("#" + sId).find('.add-opt').click(function(){
    var ol = $("#" + sId +" ol");
    var lnt = ol.children().length + 1;
    ol.append('<li class="ui-sortable-handle"><input type="radio" class="selectives" value="false" name="selected-'+ time +'-option" placeholder=""><input type="text" class="option-label" value="Option '+ lnt +'" name="selected-'+ time +'-option" placeholder="Label"><a class="remove btn" title="Remove Element">×</a></li>');

    $("#" + sId).find('.remove').click(function(){
      $(this).closest( "li" ).remove();
    });
  });

  $("#" + sId).find('.remove').click(function(){
    $(this).closest( "li" ).remove();
  });

}

function getEventsForAreaText(time, aIdEdit, blockId, sId, aIdDel)
{
  $("#" + aIdEdit).click(function() {
    $("#" + blockId).slideUp( "slow" );
    $("#" + sId).slideDown( "slow" );
  });


  $("#" + aIdDel).click(function(){
    $("#" + blockId).closest( "li" ).remove();
  });

  $("#" + sId).find('.close-settings').click(function(){
    $("#" + sId).slideUp( "slow" );
    $("#" + blockId).slideDown( "slow" );

    var sLabelValue = $("#label-" + time).val();
    $("label[for='textarea-"+ time +"']").text(sLabelValue);
  });
}

function getEventsForButton(time, aIdEdit, blockId, sId, aIdDel)
{
  $("#" + aIdEdit).click(function() {
    $("#" + blockId).slideUp( "slow" );
    $("#" + sId).slideDown( "slow" );
  });


  $("#" + aIdDel).click(function(){
    $("#" + blockId).closest( "li" ).remove();
  });

  $("#" + sId).find('.close-settings').click(function(){
    $("#" + sId).slideUp( "slow" );
    $("#" + blockId).slideDown( "slow" );
  });
}

function getEventsForHeader(time, aIdEdit, blockId, sId, aIdDel)
{
  $("#" + aIdEdit).click(function() {
    $("#" + blockId).slideUp( "slow" );
    $("#" + sId).slideDown( "slow" );
  });

  $("#" + aIdDel).click(function(){
    $("#" + blockId).closest( "li" ).remove();
  });

  $("#" + sId).find('.close-settings').click(function(){
    $("#" + sId).slideUp( "slow" );
    $("#" + blockId).slideDown( "slow" );

    // set text based on setting input label
    var sLabelValue = $("#label-" + time).val();
    $("#header-" + time).text(sLabelValue);

    // set header size value
    var hVal = $("#subtype-" + time + " option:selected").text();
    
    $("#header-" + time).replaceWith(function () {
      return "<" + hVal + " data-type='header' id='header-" + time + "' >" + $(this).html() + "</" + hVal + ">";
    });
   //'<h2 class="" data-type="header" id="header-'+ time +'">Header</h2>'
  });
}

function getEventsForFileUpload(time, aIdEdit, blockId, sId, aIdDel)
{
  $("#" + aIdEdit).click(function() {
    $("#" + blockId).slideUp( "slow" );
    $("#" + sId).slideDown( "slow" );
  });


  $("#" + aIdDel).click(function(){
    $("#" + blockId).closest( "li" ).remove();
  });

  $("#" + sId).find('.close-settings').click(function(){
    $("#" + sId).slideUp( "slow" );
    $("#" + blockId).slideDown( "slow" );

    var sLabelValue = $("#label-" + time).val();
    $("label[for='fileupload-"+ time +"']").text(sLabelValue);
  });
}

function getEventsForCheckBoxGroup(time, aIdEdit, blockId, sId, aIdDel)
{
  $("#" + aIdEdit).click(function() {
    $("#" + blockId).slideUp( "slow" );
    $("#" + sId).slideDown( "slow" );
  });


  $("#" + aIdDel).click(function(){
    $("#" + blockId).closest( "li" ).remove();
  });


  $("#" + sId).find('.close-settings').click(function(){
    $("#" + sId).slideUp( "slow" );
    $("#" + blockId).slideDown( "slow" );

    var sLabelValue = $("#label-" + time).val();
    $("label[for='control-"+ time +"']").text(sLabelValue);

    var chDiv = $("div[class*='control-"+ time +"']");
    chDiv.children().remove();

    var flag = false;

    $(':input[name="checkbox-group-'+ time + '"]').each(function(index){

      if ($(this).is( ":checkbox" ) && $(this).is(':checked'))
      {
        flag = true;
      }
      else if(!$(this).is( ":checkbox" ))
      {
          if (flag == true)
          {
            chDiv.append('<div id="checkbox-'+ time +'" class="checkbox"><input name="control-'+ time +'-1" class="selectives" id="control-'+ time +'-1" value="option-2" type="checkbox" checked="checked"><label for="checkbox-'+ time +'-1">' + $(this).val() +  '</label></div>');
            flag = false;
          }
          else if ($(this).val() != 'false')
          {
            chDiv.append($( '<div id="checkbox-'+ time +'" class="checkbox"><input name="control-'+ time +'-1" class="selectives" id="control-' + time+ '-1" value="option-2" type="checkbox"><label for="control-'+ time +'-1">' + $(this).val() + '</label></div>' ));
          }
      }

    });
  });

  //Add options
  $("#" + sId).find('.add-opt').click(function(){
        var ol = $("#" + sId +" ol");
        var lnt = ol.children().length + 1;
        
        ol.append('<li class="ui-sortable-handle"><input type="checkbox" class="selectives" name="checkbox-group-' + time + '" placeholder=""><input type="text" class="option-label" value="Option '+ lnt +'" name="checkbox-group-'+ time +'" placeholder="Label"><a class="remove btn" title="Remove Element">×</a></li>');

        $("#" + sId).find('.remove').click(function(){
          $(this).closest( "li" ).remove();
        });
      });

      $("#" + sId).find('.remove').click(function(){
        $(this).closest( "li" ).remove();
  });

}

function getEventsForRadioGroup(time, aIdEdit, blockId, sId, aIdDel)
{
  $("#" + aIdEdit).click(function() {
    $("#" + blockId).slideUp( "slow" );
    $("#" + sId).slideDown( "slow" );
  });


  $("#" + aIdDel).click(function(){
    $("#" + blockId).closest( "li" ).remove();
  });

  $("#" + sId).find('.close-settings').click(function(){
    $("#" + sId).slideUp( "slow" );
    $("#" + blockId).slideDown( "slow" );

    var sLabelValue = $("#label-" + time).val();
    $("label[for='control-"+ time +"']").text(sLabelValue);

    //var chDiv = $("div[class*='radio-group1']");
    var chDiv = $("#radiogroup-" + time);
    chDiv.children().remove();

    var flag = false;
    var n = 1;
    $(':input[name="radio-group-'+ time + '"]').each(function(index){
      if ($(this).is( ":radio" ) && $(this).is(':checked'))
      {
        flag = true;
      }
      else if(!$(this).is( ":radio" ))
      {
          if (flag == true) //bug: Somehow the if part of this code is resetting the setting radio state
          {
            chDiv.append('<div class="radio"><input name="radio-selected-group-'+ time +'" class="selectives" id="radio-selected-group-'+ time +'-'+ n +'" value="' + $(this).val() + '" checked type="radio"><label for="'+ $(this).val() +'">'+ $(this).val() + '</label></div>');
            flag = false;
          }
          else if ($(this).val() != 'false')
          {
            chDiv.append($( '<div class="radio"><input name="radio-group-'+ time +'" class="selectives" id="radio-group-'+ time +'-'+ n +'" value="' + $(this).val() + '" type="radio"><label for="' + $(this).val() + '">'+ $(this).val() + '</label></div>' ));
          }
      }
      n++;
    });
  });

  //Add options
  $("#" + sId).find('.add-opt').click(function(){
          var ol = $("#" + sId +" ol");
          var lnt = ol.children().length + 1;
          
          ol.append('<li class="ui-sortable-handle"><input type="radio" class="selectives" value="false" name="radio-group-' + time + '" placeholder=""><input type="text" class="option-label" value="Option ' + lnt + '" name="radio-group-' + time + '" placeholder="Label"><a class="remove btn" title="Remove Element">×</a></li>');

          $("#" + sId).find('.remove').click(function(){
            $(this).closest( "li" ).remove();
          });
  });

        $("#" + sId).find('.remove').click(function(){
          $(this).closest( "li" ).remove();
    });
}

function getEventsForAction(time, aIdEdit, blockId, sId, aIdDel)
{
  var selectedItem = '';
  var val = $("#subtype-caller-" + time).find(":selected").val();
  
  $("#" + aIdEdit).click(function() {
    
    $("#" + blockId).slideUp( "slow" );

    $("#" + sId).slideDown( "slow" );
  
    //The order of the two following lines is important
    selectedItem = $("#subtype-caller-" + time).find(":selected").val();
    
    $("#subtype-caller-" + time).children().remove();
    
    $("[data-type='select'], [data-type='checkboxgroup']").each(function(index,item){
      if(selectedItem == item.id)
        $("#subtype-caller-" + time).append('<option value="'+ item.id +'" selected>'+ item.id +'</option>');
      else
      $("#subtype-caller-" + time).append('<option value="'+ item.id +'">'+ item.id +'</option>');
    });

    var val = $("#subtype-caller-" + time).find(":selected").val();
    
    var type = $("#" + val).attr('data-type');
    
    if (type=='select')
    {
      //set condition to select
      $("#subtype-condition-"+ time).val("select");
    }
    else if(type=='checkboxgroup')
    {
      //set condition to check
      $("#subtype-condition-"+ time).val("check");
    }

    //subtype-targets-1530872631901
    var selectedItems = [];
    $.each($("#subtype-targets-" + time).find(":selected"), function(){
      selectedItems.push($(this).val());
    }); 
    
    $("#subtype-targets-" + time).children().remove();
    $("[data-type]").each(function(index,item){
      selectedItem = $("#subtype-caller-" + time).find(":selected").val();
      if(item.id.startsWith('action-') || item.id.startsWith('subtype-caller-') || item.id.startsWith('button-')|| item.id.startsWith('header-') || item.id == selectedItem)
        return true;

      if(selectedItems.includes(item.id))
        $("#subtype-targets-" + time).append('<option value="'+ item.id +'" selected>'+ item.id +'</option>');
      else
      $("#subtype-targets-" + time).append('<option value="'+ item.id +'">'+ item.id +'</option>');

    });

    var subCondSelected = $("#subtype-subcondition-" + time).find(":selected").val();

    $("#subtype-subcondition-" + time).children().remove();

  $("#" + val + " option").each(function(index, itm){
    if (subCondSelected == $(this).val())
      $("#subtype-subcondition-" + time).append('<option selected value="'+ $(this).val() +'">'+ $(this).val() +'</option>');
    else
      $("#subtype-subcondition-" + time).append('<option value="'+ $(this).val() +'">'+ $(this).val() +'</option>');
  });

  });


  $("#subtype-caller-" + time).on('change', function() {
    var val = $("#subtype-caller-" + time).find(":selected").val();
    var type = $("#" + val).attr('data-type');
    
    if (type=='select')
    {
      //set condition to select
      $("#subtype-condition-"+ time).val("select");
    }
    else if(type=='checkboxgroup')
    {
      //set condition to check
      $("#subtype-condition-"+ time).val("check");
    }


    $("#subtype-subcondition-" + time).children().remove();

    $("#" + val + " option").each(function(index, itm){
      
      $("#subtype-subcondition-" + time).append('<option value="'+ $(this).val() +'">'+ $(this).val() +'</option>');
    });
  });

  $("#" + aIdDel).click(function(){
    $("#" + blockId).closest( "li" ).remove();
  });

  $("#" + sId).find('.close-settings').click(function(){
    $("#" + sId).slideUp( "slow" );
    $("#" + blockId).slideDown( "slow" );
  });
}

function getEventsForRatingComponent(time, aIdEdit, blockId, sId, aIdDel)
{
  $("#" + aIdEdit).click(function() {
    $("#" + blockId).slideUp( "slow" );
    $("#" + sId).slideDown( "slow" );
  });

  $("#" + aIdDel).click(function(){
    $("#" + blockId).closest( "li" ).remove();
  });

  $("#" + sId).find('.close-settings').click(function(){
    $("#" + sId).slideUp( "slow" );
    $("#" + blockId).slideDown( "slow" );

    var sLabelValue = $("#label-" + time).val();
    $("label[for='ratingcomponent-"+ time +"']").text(sLabelValue);
  });
}
// End: EVENT Functions


// Start: HTML Settings
function getHtmlSettingsForInputText(time)
{
  return '<div class="form-elements">' +
    '<div class="form-group required-wrap">' +
      '<label for="required-' + time + '">Required</label>' +
      '<div class="input-wrap">' +
      '<input type="checkbox" class="selectives" name="required" id="required-' + time + '">' +
      '</div>' +
    '</div>' +
    '<div class="form-group label-wrap" style="display: block">' +
      '<label for="label-' + time + '">Label</label>' +
      '<div class="input-wrap">' +
      '<input name="label" value="Label" placeholder="Label" class="fld-label form-control" id="label-' + time + '">' +
      '</div>' +
    '</div>' +
    '<div class="form-group description-wrap" style="display: block">' +
      '<label for="description-' + time + '">Help Text</label>' +
      '<div class="input-wrap">' +
        '<input name="description" placeholder="" class="fld-description form-control" id="description-'+time+'" value="" type="text">' +
        '</div>' +
    '</div>' +
    '<div class="form-group className-wrap" style="display: block">' +
    '<label for="className-'+time+'">Class</label>' +
      '<div class="input-wrap">' +
    '<input name="className" placeholder="space separated classes" class="fld-className form-control" id="className-'+time+'" value="form-control" type="text">' +
    '</div>' +
  '</div>' +

  '<div class="form-group styleName-wrap" style="display: block">' +
    '<label for="styleName-'+time+'">Style</label>' +
      '<div class="input-wrap">' +
    '<input name="styleName" placeholder="semicolon separated styles" class="fld-className form-control" id="styleName-'+time+'" value="" type="text">' +
    '</div>' +
  '</div>' +

  '<div class="form-group value-wrap" style="display: undefined">' +
    '<label for="value-'+time+'">Value</label>' +
    '<div class="input-wrap">' +
      '<input name="value" placeholder="Value" class="fld-value form-control" id="value-'+time+'" value="" type="text">' +
    '</div>' +
  '</div>' +
  '<div class="form-group subtype-wrap">' +
    '<label for="subtype-'+time+'">Type</label>' +
    '<div class="input-wrap">' +
    '<select id="subtype-'+time+'" name="subtype" class="fld-subtype form-control">' +
      '<option label="Text Field" value="text">Text Field</option>' +
      '<option label="email" value="email">email</option>' +
      '<option label="tel" value="tel">tel</option>' +
    '</select>' +
    '</div>' +
  '</div>' +

  '<div class="form-group showduringexport-wrap">' +
    '<label for="required-'+ time +'">Show During Export</label>' +
    '<div class="input-wrap">' +
        '<input type="checkbox" class="selectives" name="required" id="showduringexport-'+ time +'">' +
    '</div>' +
  '</div>' +

  '<div class="form-group csvname-wrap" style="display: block">' +
    '<label for="csvname-' + time + '">CSV Label</label>' +
    '<div class="input-wrap">' +
      '<input name="csvname" placeholder="" class="form-control" id="csvname-'+time+'" value="" type="text">' +
      '</div>' +
  '</div>' +

  '<div class="form-group validationerror-wrap" style="display: block">' +
    '<label for="validationerror-' + time + '">On Validation Error Text</label>' +
    '<div class="input-wrap">' +
      '<input name="validationerror" placeholder="" class="form-control" id="validationerror-'+time+'" value="" type="text">' +
      '</div>' +
  '</div>' +

  '<a class="btn close-settings">Close</a>' +
  '</div>';
}

function getHtmlSettingsForSelect(time)
{
  return '<div class="form-elements">' +
            '<div class="form-group required-wrap">' +
                '<label for="required-'+ time +'">Required</label>' +
                '<div class="input-wrap">' +
                    '<input type="checkbox" class="selectives" name="required" id="required-'+ time +'">' +
                '</div>' +
            '</div>' +
            '<div class="form-group label-wrap" style="display: block">' +
                '<label for="label-'+ time +'">Label</label>' +
                '<div class="input-wrap">' +
                    '<input name="label" placeholder="Label" class="fld-label form-control" id="label-'+ time +'" >'+
                '</div>' +
            '</div>' +
            '<div class="form-group description-wrap" style="display: block">' +
                '<label for="description-'+ time +'">Help Text</label>' +
                '<div class="input-wrap">' +
                    '<input name="description" placeholder="" class="fld-description form-control" id="description-'+ time +'" value="" type="text">' +
                '</div>' +
            '</div>' +
            '<div class="form-group placeholder-wrap" style="display: block">' +
                '<label for="placeholder-'+ time +'">Placeholder</label>' +
                '<div class="input-wrap"><input name="placeholder" placeholder="" class="fld-placeholder form-control" id="placeholder-'+ time +'" value="" type="text">' +
                '</div>' +
            '</div>' +
            '<div class="form-group className-wrap" style="display: block">' +
                '<label for="className-'+ time +'">Class</label>' +
                '<div class="input-wrap">' +
                    '<input name="className" placeholder="space separated classes" class="fld-className form-control" id="className-'+ time +'" value="form-control" type="text">' +
                '</div>' +
            '</div>' +

            '<div class="form-group styleName-wrap" style="display: block">' +
                '<label for="styleName-'+ time +'">Style</label>' +
                '<div class="input-wrap">' +
                    '<input name="styleName" placeholder="semicolon separated styles" class="fld-className form-control" id="styleName-'+ time +'" value="" type="text">' +
                '</div>' +
            '</div>' +

            '<div class="form-group subtype-wrap">' +
              '<label for="subtype-'+time+'">Model Mapping</label>' +
              '<div class="input-wrap">' +
              '<select id="subtype-'+time+'" name="subtype" class="fld-subtype form-control">' +
                '<option label="Choose a model" value="choosemodel">Choose a model</option>' +
                '<option label="Organizations" value="organization">Organizations</option>' +
                '<option label="How did you hear about us" value="heard">How Did you find about us</option>' +
                '<option label="Industries" value="industry">Industries</option>' +
                '<option label="Countries" value="country">Countries</option>' +
                '<option label="Cities" value="city">Cities</option>' +
                '<option label="Genders" value="Gender">Genders</option>' +
              '</select>' +
              '</div>' +
            '</div>' +

            '<div class="form-group other-wrap">' +
              '<div class="input-wrap">' +
                '<input type="checkbox" class="selectives" name="other" id="others-'+ time +'">' +
                '<label for="other-'+ time +'">Enable "Others"</label>' +
              '</div>' +
            '</div>' +

            '<div class="form-group field-options">' +
                '<label class="false-label">Options</label>' +
                '<div class="sortable-options-wrap">' +
                  '<ol class="sortable-options ui-sortable">' +
                    '<li class="ui-sortable-handle">' +
                      '<input type="radio" value="true" class="selectives" name="selected-'+ time +'-option" placeholder="" checked="true">' +
                      '<input type="text" class="option-label" value="Option 1" name="selected-'+ time +'-option" placeholder="Label">' +
                      '<a class="remove btn" title="Remove Element">×</a>' +
                    '</li>' +
                    '<li class="ui-sortable-handle">' +
                      '<input type="radio" value="false" class="selectives" name="selected-'+ time +'-option" placeholder="">' +
                      '<input type="text" class="option-label" value="Option 2" name="selected-'+ time +'-option" placeholder="Label">' +
                      '<a class="remove btn" title="Remove Element">×</a>' +
                  '</li>' +
                    '<li class="ui-sortable-handle">' +
                      '<input type="radio" value="false" class="selectives" name="selected-'+ time +'-option" placeholder="">' +
                      '<input type="text" class="option-label" value="Option 3" name="selected-'+ time +'-option" placeholder="Label">' +
                      '<a class="remove btn" title="Remove Element">×</a>' +
                    '</li>' +
                '</ol>' +
                '<div class="option-actions">' +
                    '<a class="add add-opt">Add Option +</a>' +
                '</div>' +
              '</div>' +
            '</div>' +

            '<div class="form-group showduringexport-wrap">' +
              '<label for="required-'+ time +'">Show During Export</label>' +
              '<div class="input-wrap">' +
                  '<input type="checkbox" class="selectives" name="required" id="showduringexport-'+ time +'">' +
              '</div>' +
            '</div>' +

            '<div class="form-group csvname-wrap" style="display: block">' +
              '<label for="csvname-' + time + '">CSV Label</label>' +
              '<div class="input-wrap">' +
                '<input name="csvname" placeholder="" class="form-control" id="csvname-'+time+'" value="" type="text">' +
                '</div>' +
            '</div>' +

            '<div class="form-group validationerror-wrap" style="display: block">' +
              '<label for="validationerror-' + time + '">On Validation Error Text</label>' +
              '<div class="input-wrap">' +
                '<input name="validationerror" placeholder="" class="form-control" id="validationerror-'+time+'" value="" type="text">' +
                '</div>' +
            '</div>' +

            '<a class="btn close-settings">Close</a>' +
      '</div>';
}

function getHtmlSettingsForAreaText(time)
{
  return '<div class="form-elements">' +
    
    '<div class="form-group required-wrap">' +
      '<label for="required-' + time + '">Required</label>' +
      '<div class="input-wrap">' +
      '<input type="checkbox" class="selectives" name="required" id="required-' + time + '">' +
      '</div>' +
    '</div>' +

    '<div class="form-group label-wrap" style="display: block">' +
      '<label for="label-' + time + '">Label</label>' +
      '<div class="input-wrap">' +
      '<input name="label" placeholder="Label" class="fld-label form-control" id="label-' + time + '">' +
      '</div>' +
    '</div>' +

    '<div class="form-group description-wrap" style="display: block">' +
      '<label for="description-' + time + '">Help Text</label>' +
      '<div class="input-wrap">' +
        '<input name="description" placeholder="" class="fld-description form-control" id="description-'+time+'" value="" type="text">' +
        '</div>' +
    '</div>' +

    '<div class="form-group className-wrap" style="display: block">' +
      '<label for="className-'+time+'">Class</label>' +
        '<div class="input-wrap">' +
      '<input name="className" placeholder="space separated classes" class="fld-className form-control" id="className-'+time+'" value="form-control" type="text">' +
      '</div>' +
    '</div>' +

    '<div class="form-group styleName-wrap" style="display: block">' +
      '<label for="styleName-'+time+'">Style</label>' +
        '<div class="input-wrap">' +
      '<input name="styleName" placeholder="semicolon separated styles" class="fld-styleName form-control" id="styleName-'+time+'" value="" type="text">' +
      '</div>' +
    '</div>' +

    '<div class="form-group value-wrap" style="display: undefined">' +
      '<label for="value-'+time+'">Value</label>' +
      '<div class="input-wrap">' +
        '<input name="value" placeholder="Value" class="fld-value form-control" id="value-'+time+'" value="" type="text">' +
      '</div>' +
    '</div>' +

    '<div class="form-group showduringexport-wrap">' +
      '<label for="required-'+ time +'">Show During Export</label>' +
      '<div class="input-wrap">' +
          '<input type="checkbox" class="selectives" name="required" id="showduringexport-'+ time +'">' +
      '</div>' +
    '</div>' +

    '<div class="form-group csvname-wrap" style="display: block">' +
      '<label for="csvname-' + time + '">CSV Label</label>' +
      '<div class="input-wrap">' +
        '<input name="csvname" placeholder="" class="form-control" id="csvname-'+time+'" value="" type="text">' +
        '</div>' +
    '</div>' +

    '<div class="form-group validationerror-wrap" style="display: block">' +
      '<label for="validationerror-' + time + '">On Validation Error Text</label>' +
      '<div class="input-wrap">' +
        '<input name="validationerror" placeholder="" class="form-control" id="validationerror-'+time+'" value="" type="text">' +
        '</div>' +
    '</div>' +
    '<a class="btn close-settings">Close</a>' +
  '</div>';
}

function getHtmlSettingsForButton(time)
{
  return '<div class="form-elements">' +
          '<div class="form-group required-wrap">' +
            '<label for="subtype-'+ time +'">Types</label>' +
            '<div class="input-wrap">' +
              '<select id="subtype-'+ time +'" name="subtype" class="form-control">' +
                '<option label="submit" value="submit">submit</option>' +
                '<option label="draft" value="draft">draft</option>' +
              '</select>' +
            '</div>' +
          '</div>' +
          '<a class="close-settings">Close</a>' +
        '</div>';
}

function getHtmlSettingsForHeader(time)
{
  return '<div class="form-elements">' +
          
          '<div class="form-group required-wrap">' +
              '<label for="required-' + time + '">Required</label>' +
              '<div class="input-wrap">' +
              '<input type="checkbox" class="selectives" name="required" id="required-' + time + '">' +
              '</div>' +
            '</div>' +

            '<div class="form-group" style="display: block">' +
              '<label for="label-'+ time +'">Label</label>' +
              '<div class="input-wrap">' +
                '<input name="label" placeholder="Label" value="Header" class="form-control" id="label-'+ time +'">' +
              '</div>' +
            '</div>' +

            '<div class="form-group">' +
              '<label for="subtype-'+ time +'">Type</label>' +
              '<div class="input-wrap">' +
                '<select id="subtype-'+ time +'" name="subtype" class="form-control">' +
                  '<option label="h1" value="h1">h1</option>' +
                  '<option selected label="h2" value="h2">h2</option>' +
                  '<option label="h3" value="h3">h3</option>' +
                '</select>' +
              '</div>' +
            '</div>' +

            '<div class="form-group" style="display: block">' +
              '<label for="className-'+ time +'">Class</label>' +
              '<div class="input-wrap">' +
                '<input name="className" placeholder="space separated classes" class="form-control" id="className-'+ time +'" value="" type="text">' +
              '</div>' +
            '</div>' +

            '<div class="form-group" style="display: block">' +
              '<label for="styleName-'+ time +'">Style</label>' +
              '<div class="input-wrap">' +
                '<input name="styleName" placeholder="semicolon separated styles" class="form-control" id="styleName-'+ time +'" value="" type="text">' +
              '</div>' +
            '</div>' +

            '<a class="close-settings">Close</a>' +
          '</div>';
}

function getHtmlSettingsForFileUpload(time)
{
  return '<div class="form-elements">' +
    '<div class="form-group required-wrap">' +
      '<label for="required-' + time + '">Required</label>' +
      '<div class="input-wrap">' +
      '<input type="checkbox" class="selectives" name="required" id="required-' + time + '">' +
      '</div>' +
    '</div>' +
    '<div class="form-group label-wrap" style="display: block">' +
      '<label for="label-' + time + '">Label</label>' +
      '<div class="input-wrap">' +
      '<input name="label" value="File Upload" placeholder="Label" class="fld-label form-control" id="label-' + time + '">' +
      '</div>' +
    '</div>' +
    '<div class="form-group description-wrap" style="display: block">' +
      '<label for="description-' + time + '">Help Text</label>' +
      '<div class="input-wrap">' +
        '<input name="description" placeholder="" class="fld-description form-control" id="description-'+time+'" value="" type="text">' +
        '</div>' +
      '</div>' +

    '<div class="form-group className-wrap" style="display: block">' +
      '<label for="className-'+time+'">Class</label>' +
      '<div class="input-wrap">' +
        '<input name="className" placeholder="space separated classes" class="fld-className form-control" id="className-'+time+'" value="form-control" type="text">' +
      '</div>' +
    '</div>' +

    '<div class="form-group styleName-wrap" style="display: block">' +
      '<label for="styleName-'+time+'">Style</label>' +
      '<div class="input-wrap">' +
        '<input name="styleName" placeholder="semicolon separated styles" class="fld-styleName form-control" id="styleName-'+time+'" value="" type="text">' +
      '</div>' +
    '</div>' +

  '<div class="form-group showduringexport-wrap">' +
    '<label for="required-'+ time +'">Show During Export</label>' +
    '<div class="input-wrap">' +
        '<input type="checkbox" class="selectives" name="required" id="showduringexport-'+ time +'">' +
    '</div>' +
  '</div>' +

  '<div class="form-group csvname-wrap" style="display: block">' +
    '<label for="csvname-' + time + '">CSV Label</label>' +
    '<div class="input-wrap">' +
      '<input name="csvname" placeholder="" class="form-control" id="csvname-'+time+'" value="" type="text">' +
      '</div>' +
  '</div>' +

  '<div class="form-group validationerror-wrap" style="display: block">' +
    '<label for="validationerror-' + time + '">On Validation Error Text</label>' +
    '<div class="input-wrap">' +
      '<input name="validationerror" placeholder="" class="form-control" id="validationerror-'+time+'" value="" type="text">' +
      '</div>' +
  '</div>' +
  '<a class="btn close-settings">Close</a>' +
  '</div>';
}

function getHtmlSettingsForCheckBoxGroup(time)
{
  return '<div class="form-elements">' +
            '<div class="form-group required-wrap">' +
                '<label for="required-'+ time +'">Required</label>' +
                '<div class="input-wrap">' +
                    '<input type="checkbox" class="selectives" name="required" id="required-'+ time +'">' +
                '</div>' +
            '</div>' +
            '<div class="form-group label-wrap" style="display: block">' +
              '<label for="label-'+ time +'">Label</label>' +
              '<div class="input-wrap">' +
                '<input name="label" placeholder="Label" class="fld-label form-control" id="label-'+ time +'" >' +
                '</div>' +
              '</div>' +
            '<div class="form-group" style="display: block">' +
              '<label for="description-'+ time +'">Help Text</label>' +
              '<div class="input-wrap">' +
                '<input name="description" placeholder="" class="fld-description form-control" id="description-'+ time +'" value="" type="text">' +
              '</div>' +
            '</div>' +
            '<div class="form-group className-wrap" style="display: block">' +
              '<label for="className-'+ time +'">Class</label>' +
                '<div class="input-wrap">' +
                  '<input name="className" placeholder="space separated classes" class="fld-className form-control" id="className-'+ time +'" value="" type="text">' +
                '</div>' +
            '</div>' +

             '<div class="form-group styleName-wrap" style="display: block">' +
              '<label for="styleName-'+ time +'">Style</label>' +
                '<div class="input-wrap">' +
                  '<input name="styleName" placeholder="semicolon separated styles" class="fld-className form-control" id="styleName-'+ time +'" value="" type="text">' +
                '</div>' +
            '</div>' +

            '<div class="form-group field-options">' +
              '<label class="false-label">Options</label>' +
              '<div class="sortable-options-wrap">' +
                '<ol class="sortable-options ui-sortable">' +
                  '<li class="ui-sortable-handle">' +
                    '<input type="checkbox" class="selectives" value="true" name="checkbox-group-'+ time +'" placeholder="" checked="true">' +
                    '<input type="text" class="option-label" value="Option 1" name="checkbox-group-'+time+'" placeholder="Label">' +
                    '<a class="remove btn" title="Remove Element">×</a>' +
                  '</li>' +
                '</ol>' +
              '</div>' +
              '<div class="option-actions">' +
                 '<a class="add add-opt">Add Option +</a>' +
              '</div>' +
            '</div>' +
            '<div class="form-group showduringexport-wrap">' +
            '<label for="required-'+ time +'">Show During Export</label>' +
            '<div class="input-wrap">' +
                '<input type="checkbox" class="selectives" name="required" id="showduringexport-'+ time +'">' +
            '</div>' +
          '</div>' +

          '<div class="form-group csvname-wrap" style="display: block">' +
            '<label for="csvname-' + time + '">CSV Label</label>' +
            '<div class="input-wrap">' +
              '<input name="csvname" placeholder="" class="form-control" id="csvname-'+time+'" value="" type="text">' +
              '</div>' +
          '</div>' +

          '<div class="form-group validationerror-wrap" style="display: block">' +
            '<label for="validationerror-' + time + '">On Validation Error Text</label>' +
            '<div class="input-wrap">' +
              '<input name="validationerror" placeholder="" class="form-control" id="validationerror-'+time+'" value="" type="text">' +
              '</div>' +
          '</div>' +
          '<a class="close-settings">Close</a>' +
        '</div>';
}

function getHtmlSettingsForRadioGroup(time)
{
  return '<div class="form-elements">' +
            '<div class="form-group required-wrap">' +
              '<label for="required-'+ time +'">Required</label>' +
              '<div class="input-wrap">' +
                '<input type="checkbox" class="selectives" name="required" id="required-'+ time +'">' +
              '</div>' +
            '</div>' +

            '<div class="form-group label-wrap" style="display: block">' +
              '<label for="label-'+ time +'">Label</label>' +
              '<div class="input-wrap">' +
                '<input name="label" placeholder="Label" class="fld-label form-control" id="label-'+ time +'">' +
              '</div>' +
            '</div>' +

          '<div class="form-group description-wrap" style="display: block">' +
            '<label for="description-'+ time +'">Help Text</label>' +
            '<div class="input-wrap">' +
              '<input name="description" placeholder="" class="fld-description form-control" id="description-'+ time +'" value="" type="text">' +
            '</div>' +
          '</div>' +

          '<div class="form-group className-wrap" style="display: block">' +
            '<label for="className-'+ time +'">Class</label>' +
            '<div class="input-wrap">' +
              '<input name="className" placeholder="space separated classes" class="fld-className form-control" id="className-'+ time +'" value="" type="text">' +
            '</div>' +
          '</div>' +

          '<div class="form-group styleName-wrap" style="display: block">' +
            '<label for="styleName-'+ time +'">Style</label>' +
            '<div class="input-wrap">' +
              '<input name="styleName" placeholder="semicolon separated styles" class="fld-className form-control" id="styleName-'+ time +'" value="" type="text">' +
            '</div>' +
          '</div>' +

          '<div class="form-group other-wrap">' +
            '<label for="other-'+ time +'">Enable "Other"</label>' +
            '<div class="input-wrap">' +
              '<input type="checkbox" class="selectives" name="other" id="other-'+ time +'">' +
              '<label for="other-'+ time +'">Let users to enter an unlisted option</label>' +
            '</div>' +
          '</div>' +

          '<div class="form-group field-options">' +
            '<label class="false-label">Options</label>' +
            '<div class="sortable-options-wrap">' +
              '<ol class="sortable-options ui-sortable">' +
                '<li class="ui-sortable-handle">' +
                  '<input type="radio" class="selectives" value="false" name="radio-group-'+ time +'" placeholder="">' +
                  '<input type="text" class="option-label" value="Option 1" name="radio-group-'+ time +'" placeholder="Label">' +
                  '<a class="remove btn" title="Remove Element">×</a>' +
                '</li>' +
                '<li class="ui-sortable-handle">' +
                  '<input type="radio" class="selectives" value="false" name="radio-group-'+ time +'" placeholder="">'+
                  '<input type="text" class="option-label" value="Option 2" name="radio-group-'+ time +'" placeholder="Label">' +
                  '<a class="remove btn" title="Remove Element">×</a>' +
                '</li>' +
                '<li class="ui-sortable-handle">' +
                  '<input type="radio" class="selectives" value="false" name="radio-group-'+ time +'" placeholder="">'+
                  '<input type="text" class="option-label" value="Option 3" name="radio-group-'+ time +'" placeholder="Label">' +
                  '<a class="remove btn" title="Remove Element">×</a>' +
                '</li>' +
            '</ol>' +
            '<div class="option-actions">' +
            '<a class="add add-opt">Add Option +</a>' +
            '</div>' +
            '</div>' +
          '</div>' +

          '<div class="form-group showduringexport-wrap">' +
            '<label for="required-'+ time +'">Show During Export</label>' +
            '<div class="input-wrap">' +
                '<input type="checkbox" class="selectives" name="required" id="showduringexport-'+ time +'">' +
            '</div>' +
          '</div>' +

          '<div class="form-group csvname-wrap" style="display: block">' +
            '<label for="csvname-' + time + '">CSV Label</label>' +
            '<div class="input-wrap">' +
              '<input name="csvname" placeholder="" class="form-control" id="csvname-'+time+'" value="" type="text">' +
              '</div>' +
          '</div>' +

          '<div class="form-group validationerror-wrap" style="display: block">' +
            '<label for="validationerror-' + time + '">On Validation Error Text</label>' +
            '<div class="input-wrap">' +
              '<input name="validationerror" placeholder="" class="form-control" id="validationerror-'+time+'" value="" type="text">' +
              '</div>' +
          '</div>' +
          '<a class="close-settings">Close</a>' +
        '</div>';
}

function getHtmlSettingsForAction(time)
{
  return '<div class="form-elements">' +
    
  '<div class="form-group subtype-wrap">' +
    '<label for="subtype-'+time+'">Caller</label>' +
    '<div class="input-wrap">' +
    '<select id="subtype-caller-'+time+'" name="subtype" class="fld-subtype form-control">' +
      //'<option label="Text Field" value="text">Text Field</option>' +
    '</select>' +
    '</div>' +
  '</div>' +

  '<div class="form-group subtype-wrap">' +
    '<label for="subtype-'+time+'">Action</label>' +
    '<div class="input-wrap">' +
    '<select id="subtype-action-'+time+'" name="subtype" class="fld-subtype form-control">' +
      '<option label="Choose an action" value="choose">Choose an action</option>' +
      '<option label="show" value="show">show</option>' +
      '<option label="hide" value="hide">hide</option>' +
      '<option label="enable" value="enable">enable</option>' +
      '<option label="disable" value="disable">disable</option>' +
    '</select>' +
    '</div>' +
  '</div>' +

  '<div class="form-group subtype-wrap">' +
    '<label for="subtype-'+time+'">Condition</label>' +
    '<div class="input-wrap">' +
    '<select id="subtype-condition-'+time+'" name="subtype" class="fld-subtype form-control">' +
      '<option label="Choose a condition" value="choose">Choose a condition</option>' +
      '<option label="select" value="select">select</option>' +
      '<option label="check" value="check">check</option>' +
    '</select>' +
    '</div>' +
  '</div>' +

  '<div class="form-group subtype-wrap">' +
    '<label for="subtype-'+time+'">Sub-Condition</label>' +
    '<div class="input-wrap">' +
    '<select id="subtype-subcondition-'+time+'" name="subtype" class="fld-subtype form-control">' +
      '<option label="Choose a condition" value="choose">Choose a sub-condition</option>' +
    '</select>' +
    '</div>' +
  '</div>' +

  '<div class="form-group subtype-wrap">' +
    '<label for="subtype-'+time+'">Targets</label>' +
    '<div class="input-wrap">' +
    '<select multiple id="subtype-targets-'+time+'" name="subtype" class="fld-subtype form-control">' +
      '<option label="Text Field" value="text">Text Field</option>' +
      '<option label="email" value="email">email</option>' +
      '<option label="tel" value="tel">tel</option>' +
    '</select>' +
    '</div>' +
  '</div>' +

  '<a class="btn close-settings">Close</a>' +
  '</div>';
}

function getHtmlSettingsForRatingComponent(time)
{
  return '<div class="form-elements">' +
    
    '<div class="form-group required-wrap">' +
      '<label for="required-' + time + '">Required</label>' +
      '<div class="input-wrap">' +
      '<input type="checkbox" class="selectives" name="required" id="required-' + time + '">' +
      '</div>' +
    '</div>' +

    '<div class="form-group label-wrap" style="display: block">' +
      '<label for="label-' + time + '">Label</label>' +
      '<div class="input-wrap">' +
      '<input name="label" placeholder="Label" class="fld-label form-control" value="Rating Component:" id="label-' + time + '">' +
      '</div>' +
    '</div>' +

    '<div class="form-group description-wrap" style="display: block">' +
      '<label for="description-' + time + '">Help Text</label>' +
      '<div class="input-wrap">' +
        '<input name="description" placeholder="" class="fld-description form-control" id="description-'+time+'" value="" type="text">' +
        '</div>' +
    '</div>' +

    '<div class="form-group className-wrap" style="display: block">' +
      '<label for="className-'+time+'">Class</label>' +
        '<div class="input-wrap">' +
      '<input name="className" placeholder="space separated classes" class="fld-className form-control" id="className-'+time+'" value="form-control" type="text">' +
      '</div>' +
    '</div>' +

    '<div class="form-group styleName-wrap" style="display: block">' +
      '<label for="styleName-'+time+'">Style</label>' +
        '<div class="input-wrap">' +
      '<input name="styleName" placeholder="semicolon separated styles" class="fld-styleName form-control" id="styleName-'+time+'" value="" type="text">' +
      '</div>' +
    '</div>' +

    '<div class="form-group value-wrap" style="display: undefined">' +
      '<label for="value-'+time+'">Value</label>' +
      '<div class="input-wrap">' +
        '<input name="value" placeholder="Value" class="fld-value form-control" id="value-'+time+'" value="" type="text">' +
      '</div>' +
    '</div>' +

    '<div class="form-group showduringexport-wrap">' +
      '<label for="required-'+ time +'">Show During Export</label>' +
      '<div class="input-wrap">' +
          '<input type="checkbox" class="selectives" name="required" id="showduringexport-'+ time +'">' +
      '</div>' +
    '</div>' +

    '<div class="form-group csvname-wrap" style="display: block">' +
      '<label for="csvname-' + time + '">CSV Label</label>' +
      '<div class="input-wrap">' +
        '<input name="csvname" placeholder="" class="form-control" id="csvname-'+time+'" value="" type="text">' +
        '</div>' +
    '</div>' +

    '<div class="form-group validationerror-wrap" style="display: block">' +
      '<label for="validationerror-' + time + '">On Validation Error Text</label>' +
      '<div class="input-wrap">' +
        '<input name="validationerror" placeholder="" class="form-control" id="validationerror-'+time+'" value="" type="text">' +
        '</div>' +
    '</div>' +
    '<a class="btn close-settings">Close</a>' +
  '</div>';
}
// End: HTML Settings

// Start: Common Functions

function getHtmlActionButtons(aIdDel, aIdEdit)
{
  return '<div class="field-actions">' +
            '<a type="remove" id="'+ aIdDel +'" title="Remove Element"><span id="span-remove" class="glyphicon glyphicon-remove pull-right"></span></a>' +

            '<a type="edit" id="' + aIdEdit + '" title="Edit Element"><span id="span-edit" style="margin-right:10px" class="glyphicon glyphicon-edit pull-right"></span></a>' +
        '</div>';
}

// End: Common Functions

// Convert 

  function getConvertedControlToJson(key, control)
  {
    debugger;
    var splited = control.id.split('-');
    var controlType = splited[0];
    var controlID = splited[1];
    
    var result = '';
    switch(controlType)
    {
      case 'inputtext':
        result = getJsonForInputText(controlID);
        break;

      case 'select':
        result = getJsonForSelect(controlID);
        break;
      
      case 'textarea':
        result = getJsonForTextArea(controlID);
        break;

      case 'button':
        result = getJsonForButton(controlID);
        break;

      case 'upload':
        result = getJsonForFileUpload(controlID);
        break;
      
      case 'radiogroup':
        result = getJsonForRadioGroup(controlID);
        break;

      case 'checkboxgroup':
        result = getJsonForCheckBoxGroup(controlID);
        break;
      
      case 'header':
        result = getJsonForHeader(controlID);
        break;
      
      case 'action':
        result = getJsonForAction(controlID);
        break;
      
      case 'rating':
        result = getJsonForRatingComponent(controlID);
        break; 
    }

    if(controlType == 'checkboxgroup' || controlType == 'action')
      return result;
    return '"'+ key +'":'+result;
  }

  function getJsonForInputText(controlID)
  {
    var required = 0;
    if ($("#required-" + controlID).is(':checked')) required = 1;
    var label = $("#label-" + controlID).val();
    var helpText = $("#description-" + controlID).val();
    var className = $("#className-" + controlID).val();
    var style = $("#styleName-" + controlID).val();
    var value = $("#value-" + controlID).val();
    var type = $('#subtype-' + controlID).find(":selected").text();

    var validationError = $("#validationerror-" + controlID).val();
    var isShowDuringExport = 0;
    if ($("#showduringexport-" + controlID).is(':checked')) isShowDuringExport = 1;
    var csvLabel = $("#csvname-" + controlID).val();

    var json = '{"tag":"group","prop":{"css":""},"members":[{"tag":"label","prop":{"required":'+ required + ',"for":"inputtext-'+ controlID +'","value":"' + label + '"}},{"tag":"textbox","prop":{"style":"'+ style +'","css":"'+ className +'","required":'+ required +',"showinbackendlist":"'+ isShowDuringExport +'","csv_label":"' + csvLabel + '","hint":"'+ helpText +'","value":"'+ value +'","name":"inputtext-' + controlID + '","error":"' + validationError + '"}}]},';
     
    return json;
  }
  function getJsonForSelect(controlID)
  {
    var required = 0;
    if ($("#required-" + controlID).is(':checked')) required = 1;
    var label = $("#label-" + controlID).val();
    var helpText = $("#description-" + controlID).val();
    var className = $("#className-" + controlID).val();
    var style = $("#styleName-" + controlID).val();
    var modelMapping = $("#subtype-" + controlID).find(":selected").val();
    var isOthersChecked = $("#others-" + controlID).is(":checked");

    var validationError = $("#validationerror-" + controlID).val();
    var isShowDuringExport = 0;
    if ($("#showduringexport-" + controlID).is(':checked')) isShowDuringExport = 1;
    var csvLabel = $("#csvname-" + controlID).val();
    debugger;
    if (modelMapping == '' || modelMapping == 'choosemodel')
    {
        var n=0;
        var d = {};
        var value = '';
        var checked = false;
        var items = [];
        var defaultVal = '';
        var flag2 = false;
        $(":input[name=selected-"+ controlID +"-option]").each(function(index, element){
            flag = false;
            
            if (element.type=='radio')
            {
              checked = $(this).is(':checked');
              if(checked) flag2 = true;
            }
            else if(element.type=='text')
            {
              value = $(this).val();
              if(flag2) {
                defaultVal = value;
              }
              if(!flag2)
                items.push('{"text":"' + value + '"}');
              flag = true;
              flag2 = false;
            }
          
          d[n]={status:checked, value:value};

            if(flag) n++;
        });

        json = '{"tag":"group","prop":{"css":""},"members":[{"tag":"label","prop":{"required":'+ required +',"for":"inputtext-'+controlID+'","value":"'+ label +'"}},{"tag":"list","prop":{"css":"'+className+'","style":"'+style+'","required":'+ required +',"showinbackendlist":"'+isShowDuringExport+'","csv_label":"'+ csvLabel +'","hint":"'+ helpText + '","value":"","name":"'+ controlID +'","error":"'+validationError+'","text":"'+ defaultVal +'","items":['+ items +']}}]},';

    }
    else
    {

      if (modelMapping.toLowerCase() == 'organization')
      {
       json = '{"tag":"group","prop":{"css":""},"members":[{"tag":"label","prop":{"required":'+ required +',"for":"inputtext-'+controlID+'","value":"'+ label +'"}},{"tag":"list","prop":{"css":"'+className+'","style":"'+style+'","required":'+ required +',"showinbackendlist":"'+isShowDuringExport+'","csv_label":"'+ csvLabel +'","hint":"'+ helpText + '","value":"","name":"startup","error":"'+validationError+'","text":"choose your organization","others":'+ isOthersChecked +',"items":"","model_mapping":{"startup":"' + modelMapping + '"}}}]},';
      }
      else if(modelMapping.toLowerCase() == 'heard')
      {
        json = '{"tag":"group","prop":{"css":""},"members":[{"tag":"label","prop":{"required":'+ required +',"for":"inputtext-'+controlID+'","value":"'+ label +'"}},{"tag":"list","prop":{"css":"'+className+'","style":"'+style+'","required":'+ required +',"showinbackendlist":"'+isShowDuringExport+'","csv_label":"'+ csvLabel +'","hint":"'+ helpText + '","value":"","name":"heard","error":"'+validationError+'","text":"Select How did you hear about the program?","others":'+ isOthersChecked +',"items":"","model_mapping":{"heard":"' + modelMapping + '"}}}]},';
      }
      else if (modelMapping.toLowerCase() == 'industry')
      {
        json = '{"tag":"group","prop":{"css":""},"members":[{"tag":"label","prop":{"required":'+ required +',"for":"inputtext-'+controlID+'","value":"'+ label +'"}},{"tag":"list","prop":{"css":"'+className+'","style":"'+style+'","required":'+ required +',"showinbackendlist":"'+isShowDuringExport+'","csv_label":"'+ csvLabel +'","hint":"'+ helpText + '","value":"","name":"industry","error":"'+validationError+'","text":"choose your industry","others":'+ isOthersChecked +',"items":"","model_mapping":{"industry":"' + modelMapping + '"}}}]},';
      }
      else if (modelMapping.toLowerCase() == 'country')
      {
        json = '{"tag":"group","prop":{"css":""},"members":[{"tag":"label","prop":{"required":'+ required +',"for":"inputtext-'+controlID+'","value":"'+ label +'"}},{"tag":"list","prop":{"css":"'+className+'","style":"'+style+'","required":'+ required +',"showinbackendlist":"'+isShowDuringExport+'","csv_label":"'+ csvLabel +'","hint":"'+ helpText + '","value":"","name":"country","error":"'+validationError+'","text":"choose your country","others":'+ isOthersChecked +',"items":"","model_mapping":{"country":"' + modelMapping + '"}}}]},';
      }
      else if (modelMapping.toLowerCase() == 'city')
      {
        json = '{"tag":"group","prop":{"css":""},"members":[{"tag":"label","prop":{"required":'+ required +',"for":"inputtext-'+controlID+'","value":"'+ label +'"}},{"tag":"list","prop":{"css":"'+className+'","style":"'+style+'","required":'+ required +',"showinbackendlist":"'+isShowDuringExport+'","csv_label":"'+ csvLabel +'","hint":"'+ helpText + '","value":"","name":"city","error":"'+validationError+'","text":"choose your city","others":'+ isOthersChecked +',"items":"","model_mapping":{"city":"' + modelMapping + '"}}}]},';
      }
      else if (modelMapping.toLowerCase() == 'gender')
      {
        json = '{"tag":"group","prop":{"css":""},"members":[{"tag":"label","prop":{"required":'+ required +',"for":"inputtext-'+controlID+'","value":"'+ label +'"}},{"tag":"list","prop":{"css":"'+className+'","style":"'+style+'","required":'+ required +',"showinbackendlist":"'+isShowDuringExport+'","csv_label":"'+ csvLabel +'","hint":"'+ helpText + '","value":"","name":"gender","error":"'+validationError+'","text":"choose your gender","others":'+ isOthersChecked +',"items":"","model_mapping":{"gender":"' + modelMapping + '"}}}]},';
      }
    }
    
    return json;
  }
  function getJsonForTextArea(controlID)
  {
    var required = 0;
    if($("#required-" + controlID).is(':checked'))
      required = 1

    var label = $("#label-" + controlID).val();
    var helpText = $("#description-" + controlID).val();
    var style = $("#styleName-" + controlID).val();
    var className = $("#className-" + controlID).val();
    var value = $("#value-" + controlID).val();

    var validationError = $("#validationerror-" + controlID).val();
    var isShowDuringExport = 0;
    if ($("#showduringexport-" + controlID).is(':checked')) isShowDuringExport = 1;
    var csvLabel = $("#csvname-" + controlID).val();

    json = '{"tag":"group","prop":{"css":""},"members":[{"tag":"label","prop":{"required":'+ required +',"for":"'+ controlID +'","value":"'+ label +'"}},{"tag":"textarea","prop":{"css":"'+className+'","style":"'+style+'","required":'+ required +',"showinbackendlist":"'+isShowDuringExport+'","csv_label":"' + csvLabel + '","hint":"'+ helpText +'","value":"'+ value +'","name":"' + controlID + '","error":"'+validationError+'"}}]},';

    return json;
  }
  function getJsonForButton(controlID)
  {
    json='{"tag":"button","prop":{"css1":"","css2":"","name":"Submit","items":[{"name":"save","value":"Draft","css":"btn-warning"},{"name":"save","value":"Submit","css":"btn-primary"}]}},'
    return json;
  }
  function getJsonForFileUpload(controlID)
  {
    var required = 0;
    if($("#required-" + controlID).is(':checked'))
      required = 1;

    var label = $("#label-" + controlID).val();
    var helpText = $("#description-" + controlID).val();
    var className = $("#className-" + controlID).val();
    var style = $("#styleName-" + controlID).val();
    var value = $("#value-" + controlID).val();

    var validationError = $("#validationerror-" + controlID).val();
    var isShowDuringExport = 0;
    if ($("#showduringexport-" + controlID).is(':checked')) isShowDuringExport = 1;
    var csvLabel = $("#csvname-" + controlID).val();

    json='{"tag":"group","prop":{"css":""},"members":[{"tag":"label","prop":{"required":'+ required +',"for":"inputtext-'+controlID+'","value":"'+ label +'"}},{"tag":"upload","prop":{"css":"'+className+'","style":"'+style+'","required":'+ required +',"showinbackendlist":"'+isShowDuringExport+'","csv_label":"'+csvLabel+'","hint":"'+ helpText +'","value":"","name":"uploadfile","error":"'+validationError+'"}}]},';

    return json;
  }
  function getJsonForRadioGroup(controlID)
  {
    var required = 0;
    if ($("#required-" + controlID).is(':checked')) required = 1;
    var label = $("#label-" + controlID).val();
    var helpText = $("#description-" + controlID).val();
    var className = $("#className-" + controlID).val();
    var style = $("#styleName-" + controlID).val();
    var hasOtherOption = 0;
    if($("#other-" + controlID).is(':checked')) hasOtherOption = 1;

    var validationError = $("#validationerror-" + controlID).val();
    var isShowDuringExport = 0;
    if ($("#showduringexport-" + controlID).is(':checked')) isShowDuringExport = 1;
    var csvLabel = $("#csvname-" + controlID).val();

    var n=0;
    var d = {};
    var value = '';
    var checked = false;
    var items = [];
    var defaultVal = '';
    var flag2 = false;
    $(":input[name=radio-group-" + controlID + "]").each(function(index, element){
        flag = false;
        
        if (element.type=='radio')
        {
         checked = $(this).is(':checked');
         if(checked) flag2 = true;
        }
        else if(element.type=='text')
        {
          value = $(this).val();
          if(flag2) {
            defaultVal = value;
          }
          if(!flag2)
            items.push('{"text":"' + value + '","checked":"'+ checked +'"}');
          flag = true;
          flag2 = false;
        }
       
       d[n]={status:checked, value:value};

        if(flag) n++;
    });
    // var items = [];
    // for(var itm in d)
    // {
    //   if(d[itm].status)
    //   {
    //     items.push({"checked":1,'text':d[itm].value});
    //   }
    //   else
    //   {
    //     items.push({"checked":0,'text':d[itm].value});
    //   }
    // }
    

     json = '{"tag":"group","prop":{"css":""},"members":[{"tag":"label","prop":{"required":'+ required +',"for":"inputtext-'+controlID+'","value":"'+ label +'"}},{"tag":"radio","prop":{"css":"'+className+'","style":"'+style+'","required":'+ required +',"other":' + hasOtherOption + ',"showinbackendlist":"'+isShowDuringExport+'","csv_label":"'+ csvLabel +'","hint":"'+ helpText + '","value":"","name":"'+ controlID +'","error":"'+ validationError +'","text":"'+ defaultVal +'","items":['+ items +']}}]},';
  
    return json;
  }
  function getJsonForCheckBoxGroup(controlID)
  {
    var required = 0;
    if ($("#required-" + controlID).is(':checked')) required = 1;
    var label = $("#label-" + controlID).val();
    var helpText = $("#description-" + controlID).val();
    var className = $("#className-" + controlID).val();
    var style = $("#styleName-" + controlID).val();

    var validationError = $("#validationerror-" + controlID).val();
    var isShowDuringExport = 0;
    if ($("#showduringexport-" + controlID).is(':checked')) isShowDuringExport = 1;
    var csvLabel = $("#csvname-" + controlID).val();

    var n=0;
    var d = {};
    var value = '';
    var checked = false;
    var items = [];
    var flag = false;
    $(":input[name=checkbox-group-"+ controlID +"]").each(function(index, element){
        
        if (element.type=='checkbox')
        {
         checked = $(this).is(':checked');
        }
        else if(element.type=='text')
        {
          value = $(this).val();
          flag = true;
        }
       
       d[n]={status:checked, value:value};

        if(flag) n++;
        flag = false;
    });
    
    json = '';
    if (Object.keys(d).length == 1)
    {
      for(var itm in d)
      {
        if(d[itm].status)
        {
          if(label)
          {
            json = '"'+ uid() +'":{"tag":"group","prop":{"css":""},"members":[{"tag":"label","prop":{"required":'+ required +',"for":"inputtext-'+ controlID +'","value":"'+ label +'"}},{"tag":"checkbox","prop":{"css":"'+className+'","style":"'+style+'","required":'+ required +',"isgroup":0,"showinbackendlist":"'+isShowDuringExport+'","csv_label":"'+ csvLabel +'","checked":1,"hint":"'+ helpText + '","value":"","name":"'+ controlID +'","error":"'+validationError+'","text":"'+ d[itm].value +'"}}]},';
          }
          else
          {
            json = '"'+ uid() +'":{"tag":"group","prop":{"css":""},"members":[{"tag":"checkbox","prop":{"css":"'+className+'","style":"'+style+'","required":'+ required +',"isgroup":0,"showinbackendlist":"'+isShowDuringExport+'","csv_label":"'+ csvLabel +'","checked":1,"hint":"'+ helpText + '","value":"","name":"'+ controlID +'","error":"'+validationError+'","text":"'+ d[itm].value +'"}}]},';
          }
        }
        else
        {
          if(label)
          {
            json = '"'+ uid() +'":{"tag":"group","prop":{"css":""},"members":[{"tag":"label","prop":{"required":'+ required +',"for":"inputtext-'+ controlID +'","value":"'+label+'"}},{"tag":"checkbox","prop":{"css":"'+className+'","style":"'+style+'","required":'+ required +',"isgroup":0,"showinbackendlist":"'+isShowDuringExport+'","csv_label":"'+ csvLabel +'","hint":"'+ helpText + '","value":"","name":"'+ controlID +'","error":"'+validationError+'","text":"'+ d[itm].value +'"}}]},';
          }
          else
          {
            json = '"'+ uid() +'":{"tag":"group","prop":{"css":""},"members":[{"tag":"checkbox","prop":{"css":"'+className+'","style":"'+style+'","required":'+ required +',"isgroup":0,"showinbackendlist":"'+isShowDuringExport+'","csv_label":"'+ csvLabel +'","hint":"'+ helpText + '","value":"","name":"'+ controlID +'","error":"'+validationError+'","text":"'+ d[itm].value +'"}}]},';
          }
        }
      }
    }
    else if(Object.keys(d).length > 1)
    {
      var items = [];

      for(var itm in d)
      {
        if(d[itm].status)
        {
          items.push('{"text":"' + d[itm].value + '","checked":1}');
        }
        else
        {
          items.push('{"text":"' + d[itm].value + '","checked":0}');
        }
      }
      
      json = '"'+ uid() +'":{"tag":"group","prop":{"css":""},"members":[{"tag":"label","prop":{"required":'+ required +',"for":"inputtext-'+ controlID +'","value":"'+label+'"}},{"tag":"checkbox","prop":{"css":"'+className+'","style":"'+style+'","required":'+ required +',"isgroup":1,"showinbackendlist":"'+isShowDuringExport+'","csv_label":"'+ csvLabel +'","hint":"'+ helpText + '","name":"'+ controlID +'","error":"'+validationError+'","items":['+ items +']}}]},';
    }

    return json;
  }
  function getJsonForHeader(controlID)
  {
    var required = 0;
    if ($("#required-" + controlID).is(':checked')) required = 1;
    var label = $("#label-" + controlID).val();
    var className = $("#className-" + controlID).val();
    var style = $("#styleName-" + controlID).val();
    var type = $('#subtype-' + controlID).find(":selected").text();
    var size = type.split('')[1];
    json = '{"tag":"headline","prop":{"css":"'+className+'","style":"'+style+'","required":'+ required +',"css":"'+ className +'","size":'+ size +',"text":"'+ label +'"}},';

    return json;
  }

  function getJsonForAction(controlID)
  {
    var caller = $("#subtype-caller-" + controlID).find(":selected").text();
    var action = $("#subtype-action-" + controlID).find(":selected").text();
    var condition = $("#subtype-condition-" + controlID).find(":selected").text();
    var subcondition = $("#subtype-subcondition-" + controlID).find(":selected").text();
    var targets = [];
    $.each($("#subtype-condition-" + controlID).find(":selected"),function(){
      targets.push($(this).val());
    });
    
    var json = '';
    if (caller == ''||action == ''|| condition == ''|| targets.length==0)
      return json;
    
    json='{"caller":"' + caller + '","action":"' + action + '","items":["referalcode"],"condition":{"' + condition + '":"' + subcondition + '"}}';

    return json;
  }

  function getJsonForRatingComponent(controlID)
  {
    var required = 0;
    if ($("#required-" + controlID).is(':checked')) required = 1;
    var label = $("#label-" + controlID).val();
    var helpText = $("#description-" + controlID).val();
    var className = $("#className-" + controlID).val();
    var style = $("#styleName-" + controlID).val();
    var value = $("#value-" + controlID).val();
    var type = $('#subtype-' + controlID).find(":selected").text();

    var validationError = $("#validationerror-" + controlID).val();
    var isShowDuringExport = 0;
    if ($("#showduringexport-" + controlID).is(':checked')) isShowDuringExport = 1;
    var csvLabel = $("#csvname-" + controlID).val();

    var json = '{"tag":"group","prop":{"css":""},"members":[{"tag":"label","prop":{"required":'+ required + ',"for":"voted-'+ controlID +'","value":"' + label + '"}},{"tag":"rating","prop":{"style":"'+ style +'","css":"'+ className +'","required":'+ required +',"showinbackendlist":"'+ isShowDuringExport +'","csv_label":"' + csvLabel + '","hint":"'+ helpText +'","value":"'+ value +'","name":"voted-' + controlID + '","error":"' + validationError + '"}}]},';
     
    return json;
  }

  function uid() {
  return 'id-' + Math.random().toString(36).substr(2, 16);
};
  
</script>

<style>
  #sortable,#all-controls { list-style-type: none; margin: 0; padding: 0; margin-bottom: 1px; min-height: 200px;}

  .ui-state-highlight { margin: 1px; padding: 1px; width: 200px; }

  .c-control {
      margin-right: 0;
      margin-left: 0;
      background-color: #fff;
      border-color: #ddd;
      border-width: 1px;
      border-radius: 4px 4px 0 0;
      -webkit-box-shadow: none;
      box-shadow: 0px 0px #888888;
  }

  .form-elements {
      padding: 10px 5px;
      background: #f7f7f7;
      border-radius: 3px;
      margin: 0;
      border: 1px solid #c5c5c5;
      margin-bottom: 7px;
  }

  .mmf{
      margin: 0 0 -1px;
      padding: 10px;
      background: #fff;
      overflow: hidden;
      box-shadow: inset 0 0 0 1px #c5c5c5;
  }

  .field-actions {
      height: 20px;
      border-bottom: 1px solid #cacaca;
      margin-bottom: 10px;
  }

  .selectives {
    margin-right: 5px !important;
    margin-left: 5px !important;
  }

</style>
<div id="form-div-f7" style="border:1px solid black;padding:10px;" class="col-lg-8">
    <ul id="sortable">

    </ul>
</div>

<div>
<div id="obj-div" style="border:1px solid black;" class="col-lg-3">
    <ul id="all-controls">
        <li id="input-text" class="mmf ui-state-highlight">Input Text</li>
        <li id="select" class="mmf ui-state-highlight">Select</li>
        <li id="text-area" class="mmf ui-state-highlight">Text Area</li>
        <li id="button" class="mmf ui-state-highlight">Button</li>
        <li id="header" class="mmf ui-state-highlight">Header</li>
        <li id="checkbox-group" class="mmf ui-state-highlight">Checkbox Group</li>
        <li id="rating" class="mmf ui-state-highlight">Rating Component</li>
        <li id="radio-group" class="mmf ui-state-highlight">Radio Group</li>
        <li id="file-upload" class="mmf ui-state-highlight">File Upload</li>
        <li id="action" class="mmf ui-state-highlight">Action</li>
    </ul>
</div>

<div>
  <input type="button" class="col-lg-1 btn btn-primary" id="get-json" name="get-json" value="Get JSON">
  <input type="button" class="col-lg-1 btn" id="reset-form" name="reset-form" value="Reset Form">
</div>

</div>

<div class="col-lg-8">
<div>
<h2>JSON Result:</h2>
<strong>copy this json code in the form page Json Code)</strong>
</div>
<textarea id="result" rows="4" cols="110">

</textarea>
</div>

