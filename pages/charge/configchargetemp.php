<?php
validateLogin(true, false);//check account login
?>
<style>
body {
  background-color: #0072ff;
}
body h1 {
  text-align: center;
  color: white;
  font-size: 50px;
  font-weight: normal;
}
body ul {
  padding: 0px;
}
body ul .draggable {
  font-weight: 800;
  height: 40px;
  list-style-type: none;
  margin: 10px;
  background-color: white;
  color: #0072ff;
  width: 250px;
  line-height: 3.2;
  cursor: move;
  transition: all 200ms;
  user-select: none;
  margin: 10px auto;
  position: relative;
}
body ul .draggable:after {
  content: "kéo thả";
  right: 7px;
  font-size: 10px;
  position: absolute;
  cursor: pointer;
  line-height: 5;
  transition: all 200ms;
  transition-timing-function: cubic-bezier(0.48, 0.72, 0.62, 1.5);
  transform: translateX(120%);
  opacity: 0;
}
body ul .draggable:hover:after {
  opacity: 1;
  transform: translate(0);
}

.over {
  transform: scale(1.1, 1.1);
}

span.delete-span{
   background: #e74c3c;
	height: 40px;
	margin-right: 0px;
	text-align: center;
	color: white;
	width: 0;
	display: inline-block;
	transition: .1s linear;
    opacity: 0
}

span.edit-span{
   background: #3c81e7;
	height: 40px;
	margin-right: 20px;
	text-align: center;
	color: white;
	width: 0;
	display: inline-block;
	transition: .1s linear;
    opacity: 0
}

li:hover span {
    width: 40px;
    opacity: 1.0;
    cursor: pointer;
}

</style>
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Paypal</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lịch sử nạp</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body col-md-12" style="display:flex">
                    <h6 class="card-title">Lịch sử nạp</h6>
                </div>
               
                <div class="card-body">
                    <h1>DRAG AND DROP HTML5</h1>
                        <div class="form-group">
                        	<label>Thêm component</label>
                        	<select id="componentType" class="w-100">
                        		<option value="InfoBox">InfoBox</option>
                        		<option value="Image">Image</option>
                        		<option value="Input">Input</option>
                        		<option value="Select">Select</option>
                        		<option value="InputNumber">InputNumber</option>
                        	</select>
                        </div>
                    <button id="addComponent" type="button" class="btn btn-primary">Thêm</button>
                    <ul class="draggable-list">
                        <!--<li class="draggable" draggable="true">JavaScript</li>-->
                        <!--<li class="draggable" draggable="true">SCSS</li>-->
                        <!--<li class="draggable" draggable="true">HTML5</li>-->
                        <!--<li class="draggable" draggable="true">Awesome DnD</li>-->
                        <!--<li class="draggable" draggable="true">Follow me</li>-->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="componentEdit" tabindex="-1" role="dialog" aria-labelledby="componentEditLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="componentEditLabel">Sửa component</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEdit">
                <div class="form-group">
                    <label for="id" class="col-form-label">Label:</label>
                    <input type="text" class="form-control" name="label">
                </div>
                <div class="form-group">
                    <label for="id" class="col-form-label">Content/Placeholder:</label>
                    <input type="text" class="form-control" name="placeholder">
                </div>
                <div class="form-group">
                    <label for="account" class="col-form-label">Option(cho select, gõ xong enter):</label>
                    <input name="option" id="tags" value="" />
                </div>
                
                <div class="form-group">
                    <label for="regtime" class="col-form-label">Căn lề:</label>
                    <select id="align" class="w-100">
                        <option value="center">Giữa</option>
                		<option value="right">Trái</option>
                		<option value="left">Phải</option>
                	</select>
                </div>
                <div class="form-group">
                    <label for="regtime" class="col-form-label">Disabled:</label>
                    <select id="disabled" class="w-100">
                		<option value="true">True</option>
                		<option value="false" selected="selected">False</option>
                	</select>
                </div>
                
                <div class="form-group">
                    <label for="regtime" class="col-form-label">Readonly:</label>
                    <select id="readonly" class="w-100">
                		<option value="true">True</option>
                		<option value="false" selected="selected">False</option>
                	</select>
                </div>
                
                <div class="form-group">
                    <label for="regtime" class="col-form-label">Required:</label>
                    <select id="required" class="w-100">
                		<option value="true">True</option>
                		<option value="false" selected="selected">False</option>
                	</select>
                </div>
                
                <div class="form-group">
                    <label for="regtime" class="col-form-label">Filter:</label>
                    <select id="filter" class="w-100">
                        null/số([0-9])/chữ thường([a-z])/chữ hoa([A-Z])/chữ hoa thường(a-zA-Z)/chữ & số (a-zA-Z0-9)/chữ & số & 1 số kí tự (a-zA-Z0-9._@%-), 
                		<option value="null">Không filter</option>
                		<option value="[a-z]">chữ thường</option>
                		<option value="[0-9]">số</option>
                		<option value="[A-Z]">chữ hoa</option>
                		<option value="[a-zA-Z]">chữ hoa thường</option>
                		<option value="[a-zA-Z0-9]">chữ & số </option>
                		<option value="[a-zA-Z0-9\.\@\_\-]">chữ & số & 1 số kí tự (a-zA-Z0-9._@%-)</option>
                		<option value="[a-z0-9\.\@\_\-]">chữ thường & số & 1 số kí tự (a-zA-Z0-9._@%-)</option>
                	</select>
                </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editAccountSaveButton">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createChargeItem" tabindex="-1" role="dialog" aria-labelledby="createChargeItemLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createChargeItemLabel">Tạo loại nạp</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEdit">
                <div class="form-group">
                    <label for="id" class="col-form-label">Tên loại nạp:</label>
                    <input type="text" class="form-control" name="charge_title">
                </div>
                <div class="form-group">
                    <label for="id" class="col-form-label">Khu vực:</label>
                    <input type="text" class="form-control" name="region">
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editAccountSaveButton">Save</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    
    function dragStart(e) {
      this.style.opacity = '0.4';
      dragSrcEl = this;
      e.dataTransfer.effectAllowed = 'move';
      e.dataTransfer.setData('text/html', this.innerHTML);
    };
    
    function dragEnter(e) {
      this.classList.add('over');
    }
    
    function dragLeave(e) {
      e.stopPropagation();
      this.classList.remove('over');
    }
    
    function dragOver(e) {
      e.preventDefault();
      e.dataTransfer.dropEffect = 'move';
      return false;
    }
    
    function dragDrop(e) {
      if (dragSrcEl != this) {
        dragSrcEl.innerHTML = this.innerHTML;
        this.innerHTML = e.dataTransfer.getData('text/html');
      }
      return false;
    }
    
    function dragEnd(e) {
      var listItens = document.querySelectorAll('.draggable');
      [].forEach.call(listItens, function(item) {
        item.classList.remove('over');
      });
      this.style.opacity = '1';
    }
    
    function addEventsDragAndDrop(el) {
      el.addEventListener('dragstart', dragStart, false);
      el.addEventListener('dragenter', dragEnter, false);
      el.addEventListener('dragover', dragOver, false);
      el.addEventListener('dragleave', dragLeave, false);
      el.addEventListener('drop', dragDrop, false);
      el.addEventListener('dragend', dragEnd, false);
    }
    
    var listItens = document.querySelectorAll('.draggable');
    [].forEach.call(listItens, function(item) {
      addEventsDragAndDrop(item);
    });
    
    function addNewItem(textValue = false) {
      var newItem = (!textValue ? document.querySelector('.input').value : textValue);
      if (newItem != '') {
        var li = document.createElement('li');
        var attr = document.createAttribute('draggable');
        li.className = 'draggable';
        attr.value = 'true';
        
        var spanDelete = document.createElement('span');
        spanDelete.classList.add('delete-span');
        spanDelete.innerHTML = "<i class='fa fa-trash' aria-hidden='true'></i>";
        
        var spanEdit = document.createElement('span');
        spanEdit.classList.add('edit-span');
        spanEdit.innerHTML = "<i class='fa fa-edit' aria-hidden='true'></i>";
        
        li.setAttributeNode(attr);
        
        li.appendChild(spanDelete);
        li.appendChild(spanEdit);
        li.appendChild(document.createTextNode(newItem));
        $("ul.draggable-list").append(li);
        addEventsDragAndDrop(li);
      }
    }
    
    $('#addComponent').click(function(e) {
        var textVal = $('#componentType').val();
        addNewItem(textVal);
    });
    
    $("ul.draggable-list").on("click", "li span.delete-span", function(event){
        $(this).parent().remove();
        event.stopPropagation(); 
    });
    
    $("ul.draggable-list").on("click", "li span.edit-span", function(event){
        console.log($(this).parent().html());
        console.log('click edit');
        $('#componentEdit').modal();
    });
    
    $('#tags').tagsInput({
        'width': '100%',
        'height': '75%',
        'interactive': true,
        'defaultText': 'Tên option',
        'removeWithBackspace': true,
        'minChars': 0,
        'maxChars': 40,
        'placeholderColor': '#666666'
      });
});

</script>