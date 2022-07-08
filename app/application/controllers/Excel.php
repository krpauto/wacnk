<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


class Excel extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            redirect(base_url('login'));
        }
        date_default_timezone_set('Asia/Jakarta');
    }

    public function export_number()
    {
        $nama = 'WALIX Contacts';
        $spreadsheet = new Spreadsheet();

        //Font Color
        $spreadsheet->getActiveSheet()->getStyle('A1:C1')
            ->getFont();

        // Background color
        $spreadsheet->getActiveSheet()->getStyle('A1:C1')->getFill();

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(19);
        // Header Tabel
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nama')
            ->setCellValue('B1', 'Nomer')
            ->setCellValue('C1', 'Label');


        $i = 2;
        $no = 1;
        $res1 = $this->db->get_where('nomor', ['make_by' => $this->session->userdata('id_login')]);

        foreach ($res1->result_array() as $row) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $row['nama'])
                ->setCellValue('B' . $i, $row['nomor'])
                ->setCellValue('C' . $i, $row['label']);

            $i++;
            $no++;
        }


        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle("$nama" . date('d-m-Y H'));

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nama . '.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function import_number()
    {
        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        if (isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
            $input_a = _POST('a') - 1;
            $input_b = _POST('b') - 1;
            $input_c = _POST('c') - 1;
            $input_d = _POST('d') - 1;
            $arr_file = explode('.', $_FILES['file']['name']);
            $extension = end($arr_file);

            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($_FILES['file']['tmp_name']);

            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            for ($i = $input_a; $i < count($sheetData); $i++) {
                $nama = $sheetData[$i][$input_b];
                $nomer = $sheetData[$i][$input_c];
                $label = $sheetData[$i][$input_d];
                if ($label == '') {
                    $label = '';
                }

                $ar = array(
                    'nama' => $nama,
                    'nomor' => $nomer,
                    'label' => $label,
                    'make_by' => $this->session->userdata('id_login')
                );

                $a = $this->db->get_where('nomor', ['nomor' => $nomer, 'make_by' => $this->session->userdata('id_login')])->result_array();
                if (count($a) == 0) {
                    $this->db->insert('nomor', $ar);
                }
            }
            $this->session->set_flashdata('success', 'Berhasil import excel.');
            redirect(base_url('contacts'));
        }
    }
}
