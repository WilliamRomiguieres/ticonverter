<?php
	
		/*Importing TI-Var Lib*/
		include_once "libAdriweb\src/autoloader.php";
		include_once "libAdriweb\src/TypeHandlers/TH_0x05.php";
	
		use tivars\TIModel;
		use tivars\TIVarFile;
		use tivars\TIVarType;
		use tivars\TIVarTypes;	

	session_start();

	/*Define some constants */

	define("MIN_PAS_Y", 12);
	define("MIN_PAS_X", 0);
	define("MAX_CHAR_LINE", 33);
	define("LAST_LINE", 13);


	if(isset($_POST['course_input']) AND !empty($_POST['course_input'])){

		$course = htmlspecialchars(trim($_POST['course_input']));
		$size = strlen($course);

		$Cptlines = 0;
		$CptlinesSave = 0;
		$CptPages = 1;
		$YText = 0;
		$XText = 0;
		$stopTransfFlag = 0;

		$extCpt = 0;

		$outputString = '0→Xmin:0→Ymin:1→∆X:1→∆Y:AxesOff:BackgroundOff:ClrDraw:';



		for ($i=1; $i<=$size ; $i++) { 

			if($stopTransfFlag == 0){

				$extCpt++;

			}


			if(substr($course,$i-1,1) == '$' AND $stopTransfFlag == 0){

				$stopTransfFlag = 1; //on arrete le traitement


			}elseif (substr($course,$i-1,1) == '$' AND $stopTransfFlag == 1) {
				
				$stopTransfFlag = 0; //on reprend le traitement
			}

		 	
			echo $stopTransfFlag;


					if($extCpt % MAX_CHAR_LINE == 0){
						
						$outputString.='Text('.$YText.','.$XText.',"'.substr($course, $CptlinesSave*MAX_CHAR_LINE, MAX_CHAR_LINE).'"):'; 		
						$Cptlines++;
						$CptlinesSave++;
						$YText+=MIN_PAS_Y;
					}

					if($Cptlines == LAST_LINE){

						$outputString.='Pause :ClrDraw:';
						$YText = 0;
						$Cptlines = 0;
						$CptPages++;


				    }
				

			}

		$outputString.='Pause :ClrDraw:Disp " ';


		echo '<textarea rows="20" cols="100">'.$outputString.'</textarea>';

		/*Generate 8xp File*/
		$id_course = uniqid();
		$name = "COURS";

		$newPrgm = TIVarFile::createNew(TIVarType::createFromName("Program"), $name, TIModel::createFromName("84+"));
		$newPrgm->setContentFromString($outputString);
		$newPrgm->saveVarToFile("generatedCourses", $id_course);

		/*Go back and give download link*/

		$_SESSION['error_course'] = '<br /><span style="color:green;">Votre fichier est disponible ici: <a href="generatedCourses/'.$id_course.'.8xp">Télécharger</a></span>';

		//header('location: createCourse.php?mode=OK');





	}else{


		$_SESSION['error_course'] = '<span style="color:red;">Vous devez saisir un texte!</span>';

		header('location: createCourse.php');


	}














?>