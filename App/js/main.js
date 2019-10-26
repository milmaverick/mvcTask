$(document).ready(async function()
{
	await getPage();
	//await pagination();
	await isLogged();
	//Отправка комментария--------------------

	$("#form").submit(function(){
		var formData = new FormData(this);
		var email = formData.get('email');
		var name =  formData.get('name');
		var text =  formData.get('text');

		if(formData.get('name')){

			if(email != 0)
			{
				if(isValidEmailAddress(email))
				{
					$.ajax({
						type: "POST",
						url: "index/upload",
						data:  formData,
						processData: false,
						contentType: false,
						success: function(data)
						{
							if(data=='true')
							{
								$('#form')[0].reset();
								$('#success_ms').show();
								setTimeout(function(){
									$('#success_ms').hide();
								}, 2000);
								// pagination();
							}
							else{
								$('#danger_ms').html(data);
								$('#danger_ms').show();
							}
						}
					});
				}
				else{
					alert('Заполните корректно email');
				}
			}
		}
		return false;
	});


	//Вход В админку---------------------------------------
	$('#signinBtn').on('click', function(){
		var admin = $("#admin").val();
		var passwd = $("#password1").val();
		if(admin != 0 && passwd != 0)
		{
			var params =
			{
				'admin' : admin,
				'passwd' : passwd ,
			};
			$.ajax({
				url : 'admin/logIn' ,
				method : 'POST' ,
				data : {
					params : params,
				},
			}).done(function( msg ) {
				if(msg=="true") {
					getPage();
					$('#form2')[0].reset();
					$(".modal").modal("hide");
					$('#alert-success').html('Успешный вход!');
					$("#alert-success").show();
					setTimeout(function(){
						$('#alert-success').hide();
					}, 5000);
					$("#logOut").show();
					$("#login").hide();
					$('.res a').show();
					$('#signinBtn').hide();
				}
				else{
					$('#alert-danger').html(msg);
					$("#alert-danger").show();
					setTimeout(function(){
						$('#alert-danger').hide();
					}, 5000);
				}
			});
		}
		else{
			alert('Заполните логин и пароль');
		}
		return false;
	});


	//Выход из админки--------------

	$('#logOut').on('click', function(){
		$.ajax({
			url : 'admin/logOut' ,
			method : 'POST' ,
			success : function(data){
				getPage();
				$('.alert').hide();
				$('.res a').hide();
				$("#logOut").hide();
				$("#login").show();
				$('#signinBtn').show();
			},
			error : function(data){

				alert("ошибка");
			}
		});
	});

	//Измениние задания--------------------------------
	$('#updateCom').on('click', function(){
		var id = $("#idChange").val();
		var name = $("#nameChange").val();
		var email = $("#emailChange").val();
		var text = $("#textChange").val();
		if(name != 0 && email != 0 && text !=0 )
		{
			var params =
			{
				'id' : id,
				'name' : name,
				'email' : email ,
				'text' : text ,
			};
			$.ajax({
				url : 'index/update' ,
				method : 'POST' ,
				data : {
					params : params,
				},
			}).done(function( msg ) {
				if(msg=="true") {
					getPage();
					//pagination();
					$('#alert-success').html('Комментарий Изменен');
					$("#alert-success").show();
					setTimeout(function(){
						$('#alert-success').hide();
					}, 5000);

				}
				else{
					$('#alert-danger').html(msg);
					$("#alert-danger").show();
					setTimeout(function(){
						$('#alert-danger').hide();
					}, 5000);
				}
			});
		}
		else{
			alert('Заполните все поля');
		}
		return false;
	});


	//Форма для Входа в админку-------------------------

	$('#login').on('click', ()=> {
		$('#form2').show();
		$('#signInFormButton').show();
		$('#formChange').hide();
		$('#formChangeButton').hide();
	});

	//Форма для изменения комментарий ------------------------------------------------
	function changeElement(id){
		$('#formChange').show();
		$('#formChangeButton').show();
		$('#form2').hide();
		$('#signInFormButton').hide();
		$.ajax({
			url : 'index/update' ,
			method : 'POST' ,
			data : {
				id : id,
			},
			success : function(comments){
				comments=JSON.parse(comments);
				$('#idChange').html(comments[0]['id']);
				$('#nameChange').html(comments[0]['name']);
				$('#emailChange').html(comments[0]['email']);
				$('#textChange').html(comments[0]['text']);
			},
			error : function(comments){
				alert("ошибка");
			}
		});
	}

	$('#content').on('click','input:checkbox',function(){
		console.log('checkBox clicked');
		var id = parseInt(this.id.match(/\d+/));
		if ($(this).is(':checked')){
			var isPass=1;
		}
		else{
			var isPass=0;
		}
		var params =
		{
			'id' : id,
			'isPass' : isPass,
		};
		$.ajax({
			type: "POST",
			url: "index/isPass",
			data : {
				params : params,
			},
			success: function(data)
			{
				if("true") $('#comment'+id).removeClass('deleteElement');
			}
		});
	});

	$( "#selectorID" ).change(function() {
	 	showCom();
	});
});

//вывести все комментарии--------------------------------

function showCom(page=1)
{
	var sort = $('select').val();
	var params =
	{
		'sort' : sort,
		'page' : page,
	};
	$.ajax({
		url : 'index/showCom' ,
		method : 'POST' ,
		data : {
			params : params,
		},
		success : function(comments){
			$("#content").html(comments);
		},
		error : function(){
			alert("ошибка");
		}
	});
}

//Форма для изменения задания ------------------------------------------------
function changeElement(id){
	$('#formChange').show();
	$('#formChangeButton').show();
	$('#form2').hide();
	$('#signInFormButton').hide();
	$('#idChange').html(id);
	$('#nameChange').html($('#name'+id).html());
	$('#emailChange').html($('#email'+id).html());
	$('#textChange').html($('#text'+id).html());
}


//Пагинация страниц комментарий ------------------------------------------------------

function pagination(page=1){
	$.ajax({
		url : 'index/pagination' ,
		method : 'POST' ,
		data : {
			page :page,
		},
		success : function(comments){
			$(".pagination").html(comments);
		},
		error : function(comments){
			alert(comments);
		}
	});
	showCom(page);
	// getPage();
}

function isLogged (){
	$.ajax({
		url : 'admin/isLog' ,
		method : 'POST' ,
		data : {
			action : 'isLogged',
		},
	}).done(function( msg ) {
		if(msg=="true"){
			$("#logOut").show();
			$("#login").hide();
			$('.res a').show();
		}
		else{
			$("#logOut").hide();
			$("#login").show();
			$('.res a').hide();
		}
	})
}

function getPage() {
	$.ajax({
		url : 'index/getPage',
		method : 'GET',
		success : function(comments){
			console.log(comments);
			pagination(comments);
		},
		error : function(comments){
			alert( "Значение: " + comments['responseText'] );
			console.log(comments);
		}
	});
}

//Влидация email ---------------------------------------------------------

function isValidEmailAddress(emailAddress) {
	var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
	return pattern.test(emailAddress);
}
