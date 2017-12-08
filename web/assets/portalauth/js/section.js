/*
function submitMe($action,$id)
	{
		var yes=true;//confirm('OK or Cancel?');
		if(yes)
		{
			$('#action').val($action);
			$('#action_id').val($id);
			document.frm_sectionList.submit();
		}
	}
	function toggleCheck(){
		var checked=$('input[name =chkToggleCheck]').is(':checked');
		
		if(checked){
			$('input[id *= needToggleMe]').attr('checked', true);
		}
		else{
			$('input[id *= needToggleMe]').attr('checked', false);
		}

	}
*/
$(function () {
	$('#lang').change(function () {
        Page(1);
    });
    $('#section_type').change(function () {
        Page(1);
    });
    $('#page_size').change(function () {
        Page(1);
    });
    $('.checkAll').live('change', function () {
        $('.cb-element').attr('checked', $(this).is(':checked') ?  true : false);
        
    });
    
    $('.cb-element').live('change', function () {
        $('.cb-element').length == $('.cb-element:checked').length ? $('.checkAll').attr('checked', true) : $('.checkAll').attr('checked', false);

    });
    
    /*
    $('.p-paging > li > a').live('click', function () {

        var page = $(this).attr('id').split('_')[1];
        Page(page);
    });
	*/
    
    $('#dialog-form').dialog({
        autoOpen: false,
        modal: true,
        width: 600
    });
   
    $('#cmd-new').click(function () {
        $.get($(this).attr('href'), { sectionType: $('#section_type').val() }, function (data) {
            $('#dialog-form').html(data);
            $('#dialog-form').dialog("option", "title", "Nhập mới section");
            $('#dialog-form').dialog("open");
        });
        return false;

    });
    $('#cmd-edit').click(function () {
        if ($('.cb-element:checked').length == 0) {
            $('#dialog-form').html("<div style='text-align:center;padding-top:30px'><h3>Bạn chưa chọn section</h3><div>");
            $('#dialog-form').dialog("option", "title", "Cập nhật section");
            $('#dialog-form').dialog("open");
        }
        else {
            $.get($(this).attr('href'), { ID: $('.cb-element:checked:first').val() }, function (data) {
                $('#dialog-form').html(data);
                $('#dialog-form').dialog("option", "title", "Cập nhật section");
                $('#dialog-form').dialog("open");
            });
        }
        return false;

    });
    $('#cmd-del').click(function () {
        if ($('.cb-element:checked').length == 0) {
            $('#dialog-form').html("<div style='text-align:center;padding-top:30px'><h3>Bạn chưa chọn section</h3><div>");
            $('#dialog-form').dialog("option", "title", "Xóa section");
            $('#dialog-form').dialog("open");
        }
        else {
            var strIDs = "";
            $('.cb-element:checked').each(function () {
                strIDs += (strIDs != "") ? "," : "";
                strIDs += $(this).val();
            });
            $.get($(this).attr('href'), { IDs: strIDs, sectionType: $('#SectionType').val() }, function (data) {
                $('#dialog-form').html(data);
                $('#dialog-form').dialog("option", "title", "Xóa section");
                $('#dialog-form').dialog("open");
            });
        }
        return false;

    });
    

})
function searchFailed() {
    $("#searchresults").html("Sorry, there was a problem with the search.");
}
function Page(page) {
    $("#currentPage").val(page);

    var oSubmitButton = document.getElementById('SubmitSearch');
    oSubmitButton.click();
}
function CreateForm_SectionTypeChange(object) {
    $.get("/Administrator/Section/ParentSectionList", { sectionType: object.value }, function (data) {
        $('#ParentSectionID').html(data);
    });
}
function PostFailure() {
    alert("Failure");
}

function PostSuccess() {

}
