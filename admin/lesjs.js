function editLes(lesid)
{
	var submit_button="<button type='submit' form='lesform' class='btn btn-primary'>Bewaar</button>";
	var reset_button="<button type='reset' form='lesform' class='btn btn-secondary'>Reset</button>";
	var delete_button="<button type='button' class='btn btn-danger' onclick=\"deleteLes(" + lesid + ")\">Verwijder</button>";
	$.ajax({                                      
      url: 'lesjs.php',      
      data: { 
	      action: 'select', 
	      les_id: lesid },
	  dataType: 'json',   
      type: 'post',
      success: function(data) {
	    $('#detailsModal').modal("show");
	    $('#modal-title').empty().append("Edit les");
		$('#modal-body').empty().append(data);
		$('#modal-footer').empty().append(delete_button + reset_button + submit_button); 
	      },
      error: function() { alert("De lesdetails kunnen niet worden getoond!"); }
    });
}

function updateLes(lesid)
{
	var behlesnr = $('#behlesnr').val();
	var behdatum = $('#behdatum').val();
	var aolesnr = $('#aolesnr').val();
	var aodatum = $('#aodatum').val();
	var docent = $('#docent').val();
	var lesdoel = $('#lesdoel').val();
	$.ajax({                                      
      url: 'lesjs.php',      
      data: { 
	      action: 'update', 
	      lesid: lesid,
	      behlesnr: behlesnr,
	      behdatum: behdatum,
	      aolesnr: aolesnr,
	      aodatum: aodatum,
	      docent: docent,
	      lesdoel: lesdoel
	       },
	  //dataType: 'json',   
      type: 'post',
      success: function() {
	      //alert(data);
	    $('#detailsModal').modal("hide");
	    window.location.reload();	  
	      },
      error: function() { alert("De lesdetails kunnen niet worden ge-update!"); }
    });
}

function addLes()
{
	var addForm= "<form id='addform' onsubmit=\"insertLes();return false;\">"
		+ "<div class='form-row'>"
		+ "<div class='form-group col-md-2'>"
		+ "<label for='behlesnr'>Lesnr Beh</label>"
		+ "<input id='behlesnr' class='form-control' type='text'>"
		+ "</div>"
		+ "<div class='form-group col-md-3'>"
		+ "<label for='behdatum'>Datum Beh</label>"
		+ "<input id='behdatum' class='form-control' type='text'>"
		+ "</div>"
		+ "<div class='form-group col-md-2'>"
		+ "<label for='aolesnr'>Lesnr AO</label>"
		+ "<input id='aolesnr' class='form-control' type='text'>"
		+ "</div>"
		+ "<div class='form-group col-md-3'>"
		+ "<label for='aodatum'>Datum AO</label>"
		+ "<input id='aodatum' class='form-control' type='text'>"
		+ "</div>"
		+ "</div>"
		+ "<div class='form-group'>"
		+ "<label for='docent'>Docent</label>"
		+ "<textarea id='docent' class='form-control' rows='5'></textarea>"
		+ "</div>"
		+ "<div class='form-group'>"
		+ "<label for='lesdoel'>Doel</label>"
		+ "<textarea id='lesdoel' class='form-control' rows='5'></textarea>"
		+ "</div>"
		+ "</form>";
	var bewaarknop="<button type='submit' form='addform' class='btn btn-primary'>Bewaar</button>";			
	$('#detailsModal').modal("show");
	$('#modal-title').empty().append("Voeg les toe");	
	$('#modal-body').empty().append(addForm);
	$('#modal-footer').empty().append(bewaarknop);
}

function insertLes()
{
	var behlesnr = $('#behlesnr').val();
	var behdatum = $('#behdatum').val();
	var aolesnr = $('#aolesnr').val();
	var aodatum = $('#aodatum').val();
	var docent = $('#docent').val();
	var lesdoel = $('#lesdoel').val();
	$.ajax({                                      
      url: 'lesjs.php',      
      data: { 
	      action: 'insert',
	      behlesnr: behlesnr,
	      behdatum: behdatum,
	      aolesnr: aolesnr,
	      aodatum: aodatum,
	      docent: docent,
	      lesdoel: lesdoel
	       },
	  //dataType: 'json',   
      type: 'post',
      success: function() {
	      //alert(data);
	    $('#detailsModal').modal("hide");
	    window.location.reload();	  
	      },
      error: function() { alert("De les kon niet worden toegevoegd!"); }
    });
}

function editOpgave(opgid)
{
	var submit_button="<button type='submit' form='opgform' class='btn btn-primary'>Bewaar</button>";
	var reset_button="<button type='reset' form='opgform' class='btn btn-secondary'>Reset</button>";
	var delete_button="<button type='button' class='btn btn-danger' onclick=\"deleteOpg(" + opgid + ")\">Verwijder</button>";
	$.ajax({                                      
      url: 'lesjs.php',      
      data: { 
	      action: 'select_opg', 
	      opg_id: opgid },
	  dataType: 'json',   
      type: 'post',
      success: function(data) {
	    $('#detailsModal').modal("show");
	    $('#modal-title').empty().append("Edit opgave(n)");
		$('#modal-body').empty().append(data);
		$('#modal-footer').empty().append(delete_button + reset_button + submit_button); 
	      },
      error: function() { alert("De opgave(n)details kunnen niet worden getoond!"); }
    });
}

function addOpg(lesid)
{
	var addForm= "<form id='addform_opg' onsubmit=\"insertOpg(" + lesid + ");return false;\">"
		+ "<div class='form-group'>"
		+ "<label for='opgave'>Opgave(n)</label>"
		+ "<textarea id='opgave' class='form-control'></textarea>"
		+ "</div>"
		+ "<div class='form-group'>"
		+ "<label for='opg_url'>Math4All-link</label>"
		+ "<textarea id='opg_url' class='form-control'></textarea>"
		+ "</div>"
		+ "</form>";
	var bewaarknop="<button type='submit' form='addform_opg' class='btn btn-primary'>Bewaar</button>";			
	$('#detailsModal').modal("show");
	$('#modal-title').empty().append("Voeg opgaven(n) toe");	
	$('#modal-body').empty().append(addForm);
	$('#modal-footer').empty().append(bewaarknop);
}

function insertOpg(lesid)
{
	var opg = $('#opgave').val();
	var url = $('#opg_url').val();
	$.ajax({                                      
      url: 'lesjs.php',      
      data: { 
	      action: 'insert_opg',
	      les_id: lesid,
	      opg: opg,
	      url: url
	       },
	  //dataType: 'json',   
      type: 'post',
      success: function() {
	      //alert(data);
	    $('#detailsModal').modal("hide");
	    window.location.reload();	  
	      },
      error: function() { alert("De opgave kon niet worden toegevoegd!"); }
    });
}

function deleteLes(lesid)
{
	if(confirm("Weet je zeker dat je deze les wilt verwijderen?"))
	{
		$.ajax({                                      
	    url: 'lesjs.php',      
	    data: { 
		      action: 'delete', 
		      les_id: lesid
		      },
	    type: 'post',
	    success: function() {
		    $('#detailsModal').modal("hide");
		    window.location.reload();	  
		      },
	    error: function() { alert("De les kan niet worden verwijderd!"); }
	    	});
	}
}

function deleteOpg(opgid)
{
	if(confirm("Weet je zeker dat je deze opgave(n) wilt verwijderen?"))
	{
		$.ajax({                                      
	    url: 'lesjs.php',      
	    data: { 
		      action: 'delete_opg', 
		      opg_id: opgid
		      },
	    type: 'post',
	    success: function() {
		    $('#detailsModal').modal("hide");
		    window.location.reload();	  
		      },
	    error: function() { alert("De opgave kan niet worden verwijderd!"); }
	    	});
	}
}

function updateOpg(opgid)
{
		var opg = $("#opgave").val();
		var url = $("#opg_url").val();
		$.ajax({                                      
	    url: 'lesjs.php',      
	    data: { 
		      action: 'update_opg', 
		      opg_id: opgid,
		      opg_tekst: opg,
		      opg_url: url
		      },
	    type: 'post',
	    success: function() {
		    $('#detailsModal').modal("hide");
		    window.location.reload();	  
		      },
	    error: function() { alert("De opgave kan niet worden bijgewerkt!"); }
	    	});
}