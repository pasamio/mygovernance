function jump(fe){
	opt_key = fe.selectedIndex;
	var uri_val = fe.options[opt_key].value;
	window.open(uri_val,'_self');
	return true;
}

function findProject() {
	document.mainform.submit();
}

function DeleteProject() {
	document.mainform.sqlaction.value = "deleteprox";
	document.mainform.submit();
//	return true;
}

function updateProject() {
	document.mainform.sqlaction.value = "updateprox";	
	document.mainform.submit();
//	return true;
}

function findResponse() {
	document.mainform.submit();
//	return true;
}

function updateResponse() {
	document.mainform.sqlaction.value = "updateresp";
	document.mainform.submit();
//	return true;
}

function deleteResponse() {
	document.mainform.sqlaction.value = "deleteresp";
	document.mainform.submit();
//	return true;
}

function updateScore() {
	document.mainform.sqlaction.value = "updatescore";
	document.mainform.submit();
//	return true;
}

function editUser() {
	document.mainform.submit();
}

function jsError(msg) {
	alert("An error has occured: " + msg);
}

function approveProject() {
	document.mainform.sqlaction.value = "approveprox";
	document.mainform.submit();
}

function addDoc() {
	document.mainform.sqlaction.value = "adddoc";
	document.mainform.submit();
}

function requestAssessment() {
	document.mainform.sqlaction.value = "requestassessment";
	document.mainform.submit();
}

function markPending() {
	document.mainform.sqlaction.value = "markpending";
	document.mainform.submit();
}

function unmarkPending() {
	document.mainform.sqlaction.value = "unmarkpending";
	document.mainform.submit();
}


function rejectProject() {
	document.mainform.sqlaction.value = "rejectproject";
	document.mainform.submit();
}

function rescheduleProject() {
	document.mainform.sqlaction.value = "rescheduleproject";
	document.mainform.submit();
}