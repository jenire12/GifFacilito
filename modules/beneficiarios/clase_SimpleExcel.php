<?php
/**
* Este Archivo contiene la CLase "SimpleExcel".
* Clase Desarrollada para Manejo de Reportes en xlsx mediante PHPExcel 
* 
* Departamento de Sistemas, Oficina de Tecnología de la Información.
* E.P.S. Maderas del Orinoco, C.A.
*
* @package      SIPCAB
* @subpackage   Comun
* @license      http://opensource.org/licenses/GPL-3.0  GNU Public License V-3.0
* @author       Daniel Guzmán < dguzman1012@gmail.com>
* @created      20 de Junio de 2013
* @modified     21 de Junio de 2013
* @by           Daniel Guzmán < dguzman1012@gmail.com>
*/



/**
* Se Incluye clase PHPExcel. (Modificar ruta según lo requiera)
*/
require_once '../../libs/excel/PHPExcel.php';


/**
* Clase SimpleExcel
*
* Clase con métodos definidos para manejo de reportes en Excel.
*
* @package    SIPCAB
* @subpackage Comun
* @author     Daniel Guzmán < dguzman1012@gmail.com>
*/
class SimpleExcel{  
    private $objetoExcel;
    private $logoCorporacion;
    private $logoEmpresa;
    private $totalColumnas;
    private $filas;
    private $columnas;
    private $estado;
    private $registros;
    private $titulo;
    private $empresa;
    private $gerencia;
    private $departamento;
    private $descripcion;
    private $elaborado_por;
    private $aprobado_por;
    private $orientacion;

    /**
    * Método Constructor
    * 
    * Método en donde se definen los errores del reportes y las configuraciones iniciales del archivo.
    * Se Inicializan los atributos y se especifica título y Orientación
    *
    * @param    string $titulo Título del Reporte
    * @param    string $orientacion Orientación inicial de la Hoja Excel    
    * @return   void
    */
    public function __construct($titulo, $orientacion) {
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        setlocale(LC_TIME, 'es_VE'); # Localiza en español es_Venezuela
        date_default_timezone_set('America/Caracas');      
        $this->objetoExcel=new PHPExcel();
        $this->filas=-1;
        $this->columnas=-1;
        $this->totalColumnas=-1;
        $this->logoCorporacion='';
        $this->logoEmpresa='';
        $this->estado=false;
        $this->registros=NULL;
        $this->orientacion=$orientacion;
        $this->titulo=$titulo;
        $this->empresa='';
        $this->gerencia='';
        $this->departamento='';
        $this->descripcion='';
        $this->elaborado_por='';
        $this->aprobado_por='';
        //Se Añade la Orientación de la Pagina.        
        if ($orientacion=='VERTICAL'){
            $this->objetoExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);            
        }else{
            $this->objetoExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        }
        
        
    }
    
    
    /**
    * Métodos de Encapsulamiento: getters
    */
    
    public function getObjetoExcel(){
        return $this->objetoExcel;
    }
    public function getTitulo(){
        return $this->titulo;
    }    
    public function getOrientacion(){
        return $this->orientacion;
    }
    public function getEmpresa(){
        return $this->empresa;
    }
    public function getGerencia(){
        return $this->gerencia;
    }
    public function getDepartamento(){
        return $this->departamento;
    }
    public function getDescripcion(){
        return $this->descripcion;
    }
    public function getElaboradoPor(){
        return $this->elaborado_por;
    }
    public function getAprobadoPor(){
        return $this->aprobado_por;
    }
    public function getTotalColumnas(){
        return $this->totalColumnas;
    }
    public function getFilas(){
        return $this->filas;
    }
    public function getColumnas(){
        return $this->columnas;    
    }
    public function getLogoCorporacion(){
        return $this->logoCorporacion;
    }    
    public function getLogoEmpresa(){
        return $this->logoEmpresa;
    }
    public function getEstado(){
        return $this->estado;
    }
    public function getRegistros(){
        return $this->registros;
    }

    
    /**
    * Métodos de Encapsulamiento: setters
    */
    
    public function setTotalColumnas($total){
        $this->totalColumnas=$total;
    }
    public function setEmpresa($empresa){
        $this->empresa=$empresa;
    }
    public function setGerencia($gerencia){
        $this->gerencia=$gerencia;
    }
    public function setDepartamento($departamento){
        $this->departamento=$departamento;
    }
    public function setDescripcion($descripcion){
        $this->descripcion=$descripcion;
    }
    public function setElaboradoPor($elaborado_por){
        $this->elaborado_por=$elaborado_por;
    }
    public function setAprobadoPor($aprobado_por){
        $this->aprobado_por=$aprobado_por;
    }
    public function setFilas($filas){
        $this->filas=$filas;
    }
    public function setColumnas($columnas){
        $this->columnas=$columnas;
    }
    public function setLogoCorporacion($logo){
        $this->logoCorporacion=$logo;
    }
    public function setLogoEmpresa($logo){
        $this->logoEmpresa=$logo;
    }
    public function setEstado($estado){
        $this->estado=$estado;
    }
    public function setRegistros($row){
        $this->registros=$row;
    }
    
    
    
    /**
    * Métodos de funcionamiento de la Clase
    */
    
    
    /**
    * Método Cabeceras()
    * 
    * Método en donde se validan los registros de entrada.
    * Se definen las propiedades de la Hoja de Excel.
    * Se Inicializa la cabecera para impresión.
    * Se Añaden los logos de la empresa.
    * Se Añade el Membrete del Reporte.
    *
    * @param    void    
    * @return   void
    */
    public function Cabeceras(){        
        $this->validaRegistros();
        $this->definirPropiedades();
        $this->objetoExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&LElaborado por:' .$this->elaborado_por.'&CAprobado por:' .$this->aprobado_por. '&RImpreso el: ' . date('d/m/Y') . "\n");        
                
        $Corporacion = new PHPExcel_Worksheet_Drawing();
        $Empresa = new PHPExcel_Worksheet_Drawing();
        if (file_exists($this->logoCorporacion)){
            $Corporacion->setName('Corporacion');
            $Corporacion->setDescription('Corporacion');
            $Corporacion->setPath($this->logoCorporacion);
            $this->columna=1;
            $this->fila=1;            
            $Corporacion->setCoordinates($this->equivalente_letras(0).$this->fila);
            $Corporacion->setHeight(95);
            $Corporacion->setWorksheet($this->objetoExcel->getActiveSheet());
        }
        
        if (file_exists($this->logoEmpresa)){
            $Empresa->setName('Empresa');
            $Empresa->setDescription('Empresa');
            $Empresa->setPath($this->logoEmpresa);
            if ($this->estado){
                $this->columna=  $this->totalColumnas+2;
            }else{
                if ($this->orientacion=='VERTICAL'){
                    $this->columna= 7;
                }else{
                    $this->columna= 10;
                }

            }        
            $this->fila=1;
            $Empresa->setCoordinates($this->equivalente_letras($this->totalColumnas+1).$this->fila);
            $Empresa->setHeight(95);
            $Empresa->setWorksheet($this->objetoExcel->getActiveSheet());
        }        
        $this->membrete();
        
    }
        
    
    /**
    * Método definirPropiedades()
    * 
    * Método en donde se definen las propiedades de la Hoja de Excel.    
    * Se especifica el creador, la ultima modificación, el titulo y la descripción.    
    *
    * @param    void    
    * @return   void
    */
    private function definirPropiedades(){
        $this->objetoExcel->getProperties()->setCreator($this->elaborado_por);
        $this->objetoExcel->getProperties()->setLastModifiedBy($this->aprobado_por);
        $this->objetoExcel->getProperties()->setTitle($this->titulo);
        $this->objetoExcel->getProperties()->setDescription($this->descripcion);

    }

    
    /**
    * Método piePagina()
    * 
    * Método que define el pié de página del Archivo Excel.
    * Se especifica el titulo de archivo a la izquierda,
    *  y el numero de página a la derecha.
    *
    * @param    void    
    * @return   void
    */
    public function piePagina(){
        $this->objetoExcel->getActiveSheet()->getHeaderFooter()->
                setOddFooter('&L&B' . $this->objetoExcel->getProperties()->getTitle() . '&RPágina &P de &N');
    }
    
    
    /**
    * Método validaRegistros()
    * 
    * Método que valida el resultado del query de entrada.
    * Asigna el valor del total de columnas para el control del reporte
    * Si contiene registros que mostrar, cambia el estado a verdadero,
    * sino, el estado será falso.
    *
    * @param    void    
    * @return   void
    */
    private function validaRegistros(){
        if ($this->registros){
			$this->totalColumnas=  $this->registros->columnCount();
            if ($this->registros->RowCount()>0){
                $this->estado=TRUE;                
            }else{
                $this->estado=FALSE;                
            }
        }else{
            printf("******* Error: El registro de entrada está vacío!! ************\n\n");
            die();
        }
    }
    
    
    /**
    * Método aumentaFila()
    * 
    * Método que aumenta el iterador de la fila.
    *
    * @param    void    
    * @return   void
    */
    public function aumentaFila(){
        $this->fila++;
    }

    
    /**
    * Método membrete()
    * 
    * Método en donde se imprime el membrete del reporte.
    * El Membrete consta de: Nombre de Empresa, Gerencia, Departamento y Descripción de Reporte
    *
    * @param    void    
    * @return   void
    */
    private function membrete(){
        $this->fila=2;
        $this->columna=2;        
        
        $styleArray = array(            
            'font' => array(
                'bold' => false,                
                'size' => 10
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID                
            )
        );
        
        $this->objetoExcel->getActiveSheet()->getStyle($this->equivalente_letras($this->columna).$this->fila)->applyFromArray($styleArray);
        $this->objetoExcel->getActiveSheet()->mergeCells($this->equivalente_letras($this->columna).$this->fila.':'.$this->equivalente_letras($this->totalColumnas-1).$this->fila);        
        $this->objetoExcel->getActiveSheet()->setCellValueByColumnAndRow($this->columna , $this->fila, $this->empresa);
        $this->fila++;
        $this->objetoExcel->getActiveSheet()->getStyle($this->equivalente_letras($this->columna).$this->fila)->applyFromArray($styleArray);
        $this->objetoExcel->getActiveSheet()->mergeCells($this->equivalente_letras($this->columna).$this->fila.':'.$this->equivalente_letras($this->totalColumnas-1).$this->fila);        
        $this->objetoExcel->getActiveSheet()->setCellValueByColumnAndRow($this->columna , $this->fila, $this->gerencia);
        $this->fila++;
        $this->objetoExcel->getActiveSheet()->getStyle($this->equivalente_letras($this->columna).$this->fila)->applyFromArray($styleArray);
        $this->objetoExcel->getActiveSheet()->mergeCells($this->equivalente_letras($this->columna).$this->fila.':'.$this->equivalente_letras($this->totalColumnas-1).$this->fila);        
        $this->objetoExcel->getActiveSheet()->setCellValueByColumnAndRow($this->columna , $this->fila, $this->departamento);
        $this->fila++;        
        $this->objetoExcel->getActiveSheet()->getStyle($this->equivalente_letras($this->columna).$this->fila)->applyFromArray($styleArray);
        $this->objetoExcel->getActiveSheet()->mergeCells($this->equivalente_letras($this->columna).$this->fila.':'.$this->equivalente_letras($this->totalColumnas-1).$this->fila);
        $this->objetoExcel->getActiveSheet()->getStyle($this->equivalente_letras($this->columna).$this->fila)->getFont()->setSize(9);
        $this->objetoExcel->getActiveSheet()->getStyle($this->equivalente_letras($this->columna).$this->fila)->getFont()->setBold(true);
        $this->objetoExcel->getActiveSheet()->setCellValueByColumnAndRow($this->columna , $this->fila, $this->descripcion);
    }
    
    
    /**
    * Método agregarDatos()
    * 
    * Método en donde se carga los datos del reporte.
    * Se agrega el título de la tabla a mostrar.
    * Se verifica el estado del objeto (Previa validacion de registros hecha en -> validaRegistros).
    * Si el estado es verdadero: Se procede a cargar la Cabecera de la tabla y
    * luego se imprime el Detalle de la Tabla.
    * Si el estado es falso: Muestra un mensaje diciendo: "NO EXISTEN DATOS PARA MOSTRAR"
    *
    * @param    void    
    * @return   void
    */
    public function agregarDatos(){
        $this->tituloTabla();
        if ($this->estado){ 
            $this->cabeceraTabla();
            $styleArray = array(
                'borders' => array(
                  'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_HAIR
                  )
                ),
                'font' => array(                    
                    'size' => 8
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
                )                
            );
            foreach ($this->registros as $fila){
                $this->fila++;
                for ($i=0;$i<$this->totalColumnas;$i++){					
                    $this->objetoExcel->getActiveSheet()->getStyle($this->equivalente_letras($this->columna+$i).$this->fila)->applyFromArray($styleArray);
                    $this->objetoExcel->getActiveSheet()->setCellValueByColumnAndRow($this->columna + $i , $this->fila, $fila[$i]);
                }
            }
            unset($styleArray);
        }else{
            
            $this->fila+=2;
            $this->columna=2;
            
            $styleArray = array(
                'borders' => array(
                  'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                  )
                ),
                'font' => array(
                    'bold' => true,
                    'size' => 9
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID                    
                )
            );
            
            $this->objetoExcel->getActiveSheet()->getStyle($this->equivalente_letras($this->columna).$this->fila)->applyFromArray($styleArray);
            $this->objetoExcel->getActiveSheet()->mergeCells($this->equivalente_letras($this->columna).$this->fila.':'.$this->equivalente_letras($this->totalColumnas-1).$this->fila);
            $this->objetoExcel->getActiveSheet()->setCellValueByColumnAndRow($this->columna , $this->fila, 'NO EXISTEN DATOS PARA MOSTRAR');
            unset($styleArray);
        }
        
    }
    
    
    /**
    * Método cabeceraTabla()
    * 
    * Método en donde se carga la cabecera de la tabla.        
    *
    * @param    void    
    * @return   void
    */
    private function cabeceraTabla(){
        $this->fila+=3;
        $this->columna=1;
        
        $styleArray = array(
            'borders' => array(
              'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_HAIR
              )
            ),
            'font' => array(
                'bold' => true,
                'color' => array(
                    'argb' => PHPExcel_Style_Color::COLOR_WHITE,
                ),
                'size' => 10
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,                
                'color' => array(
                    'argb' => '22662B',
                )
            )
        );

        $this->objetoExcel->getActiveSheet()->getStyle($this->equivalente_letras($this->columna).$this->fila.':'.$this->equivalente_letras($this->totalColumnas).$this->fila)->applyFromArray($styleArray);
        
        for ($i=0;$i<$this->totalColumnas;$i++){
           $nombre = $this->registros->getColumnMeta($i);
           $this->objetoExcel->getActiveSheet()->setCellValueByColumnAndRow($this->columna + $i , $this->fila, ucfirst($nombre['name']));
        }
        unset($styleArray);
    }

    
    /**
    * Método tituloTabla()
    * 
    * Método en donde se imprime el Titulo de la tabla a mostrar
    *
    * @param    void    
    * @return   void
    */
    private function tituloTabla(){
        $this->fila+=5;
        $this->columna=2;
        
        $styleArray = array(            
            'font' => array(
                'bold' => true,
                'color' => array(
                    'argb' => 'DB4921',
                ),
                'size' => 15
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            )            
        );
        
        $this->objetoExcel->getActiveSheet()->getStyle($this->equivalente_letras($this->columna).$this->fila)->applyFromArray($styleArray);        
        $this->objetoExcel->getActiveSheet()->setCellValueByColumnAndRow($this->columna , $this->fila, $this->titulo);                
        $this->objetoExcel->getActiveSheet()->mergeCells($this->equivalente_letras($this->columna).$this->fila.':'.$this->equivalente_letras($this->totalColumnas-1).$this->fila);
        $this->objetoExcel->getActiveSheet()->getRowDimension($this->fila)->setRowHeight(20);
        unset($styleArray);
    }
    
    
    /**
    * Método exportar()
    * 
    * Método que Redirige la salida al navegador web del cliente (Excel2007)
    *
    * @param    void    
    * @return   void
    */
    public function exportar(){        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$this->titulo.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->objetoExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    
    
    /**
    * Método equivalente_letras($col)
    * 
    * Método que me devuelve el equivalente en letra del numero de columna que reciba
    *
    * @param    int $col Columna
    * @return   string
    */
    private function equivalente_letras($col){
		$letras= array(
				'A','B','C','D','E','F','G','H','I','J','K','L','M',
				'N','O','P','Q','R','S','T','U','V','W','X','Y','Z'
					);
		if (isset($letras[$col])){
			return $letras[$col];
		}else{
			return 'K';
		}
    }
    

    
    /**
    * Método Destructor
    * 
    * Método destructor de la clase, en él se libera el objeto.
    *
    * @param    void    
    * @return   void
    */
    public function __destruct(){
        unset($this);
    }
    
}
