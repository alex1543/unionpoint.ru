


function browserDetectNav(chrAfterPoint)
{
var
    UA=window.navigator.userAgent,       // содержит переданный браузером юзерагент
    //--------------------------------------------------------------------------------
	OperaB = /Opera[ \/]+\w+\.\w+/i,     //
	OperaV = /Version[ \/]+\w+\.\w+/i,   //	
	FirefoxB = /Firefox\/\w+\.\w+/i,     // шаблоны для распарсивания юзерагента
	ChromeB = /Chrome\/\w+\.\w+/i,       //
	SafariB = /Version\/\w+\.\w+/i,      //
	IEB = /MSIE *\d+\.\w+/i,             //
	SafariV = /Safari\/\w+\.\w+/i,       //
        //--------------------------------------------------------------------------------
	browser = new Array(),               //массив с данными о браузере
	browserSplit = /[ \/\.]/i,           //шаблон для разбивки данных о браузере из строки
	OperaV = UA.match(OperaV),
	Firefox = UA.match(FirefoxB),
	Chrome = UA.match(ChromeB),
	Safari = UA.match(SafariB),
	SafariV = UA.match(SafariV),
	IE = UA.match(IEB),
	Opera = UA.match(OperaB);
		
		//----- Opera ----
		if ((!Opera=="")&(!OperaV=="")) browser[0]=OperaV[0].replace(/Version/, "Opera")
				else 
					if (!Opera=="")	browser[0]=Opera[0]
						else
							//----- IE -----
							if (!IE=="") browser[0] = IE[0]
								else 
									//----- Firefox ----
									if (!Firefox=="") browser[0]=Firefox[0]
										else
											//----- Chrom ----
											if (!Chrome=="") browser[0] = Chrome[0]
												else
													//----- Safari ----
													if ((!Safari=="")&&(!SafariV=="")) browser[0] = Safari[0].replace("Version", "Safari");
//------------ Разбивка версии -----------

	var
            outputData;                                      // возвращаемый функцией массив значений
                                                             // [0] - имя браузера, [1] - целая часть версии
                                                             // [2] - дробная часть версии
	if (browser[0] != null) outputData = browser[0].split(browserSplit);
	if ((chrAfterPoint==null)&&(outputData != null)) 
		{
			chrAfterPoint=outputData[2].length;
			outputData[2] = outputData[2].substring(0, chrAfterPoint); // берем нужное ко-во знаков
			return(outputData);
		}
			else return(false);
}


window.onload = function(){

	var elementNAV = document.getElementById("nav");
	elementNAV.onmouseover = function() {
		document.getElementById("nav").style.height="50px";
		document.getElementById("nav").style.backgroundColor="#FFE393";
		
		var elementExists = document.getElementById("A1");
		
	if (!elementExists) {
		
		document.getElementById("nav").removeChild(document.getElementById('A6'));
		
		var elementA1 = document.createElement('a');
		document.getElementById("nav").appendChild(elementA1);
		elementA1.innerHTML = 'Управление сайтом';
		elementA1.id='A1';
		elementA1.href="admin.site.php";
		
		var elementA2 = document.createElement('a');
		document.getElementById("nav").appendChild(elementA2);
		elementA2.innerHTML = 'Пользователи';
		elementA2.id='A2';
		elementA2.href="admin.php";
		
		var elementA3 = document.createElement('a');
		document.getElementById("nav").appendChild(elementA3);
		elementA3.innerHTML = 'Администрирование БД';
		elementA3.id='A3';
		elementA3.href="admin.db.php";
		
		var elementA4 = document.createElement('a');
		document.getElementById("nav").appendChild(elementA4);
		elementA4.innerHTML = 'Редактирование инструкций';
		elementA4.id='A4';
		elementA4.href="edit.php";
		
		var elementA5 = document.createElement('a');
		document.getElementById("nav").appendChild(elementA5);
		elementA5.innerHTML = 'Дополнительно';
		elementA5.id='A5';
		elementA5.href="admin.dop.php";		

	}

	}

		var elementA6 = document.createElement('a');
		document.getElementById("nav").appendChild(elementA6);
		elementA6.innerHTML = '<i>Управление сайтом!</i>';
		elementA6.id='A6';
		document.getElementById("A6").style.float="right";
		document.getElementById("A6").style.height="15px";
		document.getElementById("A6").style.padding="3px";
		document.getElementById("A6").style.color="#FFF";
		

			var data = browserDetectNav();
 // alert("Браузер: "+data[0]+", Версия: "+data[1]+"."+data[2]); //выводим результат
		document.getElementById("vbr").innerHTML = data[0];

		
	if (data[0]=="Firefox") {
// alert("Браузер: "+data[0]+", Версия: "+data[1]+"."+data[2]); //выводим результат
		document.getElementById("mainImg").style.marginTop="45px";
	}		
	if (data[0]=="Safari") {
// alert("Браузер: "+data[0]+", Версия: "+data[1]+"."+data[2]); //выводим результат
//  планшет
	}
	
	
}	
