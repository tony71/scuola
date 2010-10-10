<?php
	$filename=$_POST['filename'];
	// header ("Content-Type: application/vnd.ms-excel");
	header ("Content-Type: text/xml");
	header ("Content-Disposition: inline; filename=$filename");
	require_once('include/db_connection.php');
	$query = pg_escape_string($_POST['sql']);
	try {
		// $sql = "select xmlroot(xmlconcat(xmlpi(name \"mso-application\", 'progid=\"Excel.Sheet\"'),query_to_xml_and_xmlschema('$query'::text, true, false, 'Prova')),version '1.0', standalone yes)";
		$sql = "select query_to_xml_and_xmlschema('$query'::text, true, false, 'Prova')";
		$stm = $db->query($sql);
		$r = $stm->fetch(PDO::FETCH_BOTH);
		// echo $r[0];
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
?>
<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
  xmlns:o="urn:schemas-microsoft-com:office:office"
  xmlns:x="urn:schemas-microsoft-com:office:excel"
  xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
  xmlns:html="http://www.w3.org/TR/REC-html40">
  <DocumentProperties 
     xmlns="urn:schemas-microsoft-com:office:office">
 <Author>Jack Herrington</Author>
  <LastAuthor>Jack Herrington</LastAuthor>
  <Created>2005-08-02T04:06:26Z</Created>
  <LastSaved>2005-08-02T04:30:11Z</LastSaved>
  <Company>My Company, Inc.</Company>
  <Version>11.6360</Version>
  </DocumentProperties>
  <ExcelWorkbook 
     xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>8535</WindowHeight>
  <WindowWidth>12345</WindowWidth>
  <WindowTopX>480</WindowTopX>
  <WindowTopY>90</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
  </ExcelWorkbook>
  <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
  <Alignment ss:Vertical="Bottom"/>
  <Borders/>
  <Font/>
  <Interior/>
  <NumberFormat/>
  <Protection/>
  </Style>
  <Style ss:ID="s21" ss:Name="Hyperlink">
  <Font ss:Color="#0000FF" ss:Underline="Single"/>
  </Style>
  <Style ss:ID="s23">
  <Font x:Family="Swiss" ss:Bold="1"/>
  </Style>
  </Styles>
  <Worksheet ss:Name="Names">
<?php echo $r[0]; ?>
<WorksheetOptions 
     xmlns="urn:schemas-microsoft-com:office:excel">
  <Print>
  <ValidPrinterInfo/>
  <HorizontalResolution>300</HorizontalResolution>
  <VerticalResolution>300</VerticalResolution>
  </Print>
  <Selected/>
  <Panes>
  <Pane>
  <Number>3</Number>
  <ActiveRow>1</ActiveRow>
  </Pane>
  </Panes>
  <ProtectObjects>False</ProtectObjects>
  <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
  </Worksheet>
  </Workbook>

