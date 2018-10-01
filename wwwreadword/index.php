<?php

require 'vendor/autoload.php';


$source = __DIR__."/docs/text.docx";

$objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');

$phpWord = $objReader->load($source);


$body = '';
foreach($phpWord->getSections() as $section) {
	$arrays = $section->getElements();
	
	foreach($arrays as $e) {
		if(get_class($e) === 'PhpOffice\PhpWord\Element\TextRun') {
			foreach($e->getElements() as $text) {
				
				$font = $text->getFontStyle();
				
				$size = $font->getSize()/10;
				$bold = $font->isBold() ? 'font-weight:700;' :'';
				$color = $font->getColor();
				$fontFamily = $font->getName();
				
				$body .= '<span style="font-size:' . $size . 'em;font-family:' . $fontFamily . '; '.$bold.'; color:#'.$color.'">';
				$body .= $text->getText().'</span>';
				
				//print_r($font);
				//break;
				
				//$text->getText();
			}
		}
		
		else if(get_class($e) === 'PhpOffice\PhpWord\Element\TextBreak') {
			$body .= '<br />';
		}
		
		else if(get_class($e) === 'PhpOffice\PhpWord\Element\Table') {
			$body .= '<table border="2px">';
			
			$rows = $e->getRows();
			
			foreach($rows as $row) {
				$body .= '<tr>';
				
				$cells = $row->getCells();
				foreach($cells as $cell) {
					$body .= '<td style="width:'.$cell->getWidth().'">';
					$celements = $cell->getElements();
					foreach($celements as $celem) {
						if(get_class($celem) === 'PhpOffice\PhpWord\Element\Text') {
							$body .= $celem->getText();
						}
						
						else if(get_class($celem) === 'PhpOffice\PhpWord\Element\TextRun') {
							foreach($celem->getElements() as $text) {
								$body .= $text->getText();
							}
						}
						else {
							//$body .= get_class($celem);
						}
					}	
					$body .= '</td>';
				}
				
				$body .= '</tr>';
			}
			
			
			$body .= '</table>';
		}
		else {
			$body .= $e->getText();
		}
	}
	
	break;
}

include 'templ.php';

