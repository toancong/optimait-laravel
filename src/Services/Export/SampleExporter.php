<?php
namespace Optimait\Laravel\Services\Export;

use Response;

class SampleExporter extends AbstractExporter implements ExportInterface
{

    public function export($data)
    {
        $output = '';
        //First lets get the headings
        $output .= implode(',', $this->heading) . "\n";

        foreach ($data['order_id'] as $k => $order) {
            $output .= $this->escapeAndReturn(array(
                $order,
                $data['customer'][$k],
                $data['campaign'][$k],
                $data['gateway'][$k],
                $data['product'][$k],
                $data['price'][$k],
                $data['tracking'][$k],

            ));


            $output .= "\n";
        }
        $filename = $this->filename != '' ? $this->filename : 'Exports-' . @date('Y-m-d-H-i-s');
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
        );

        return Response::make($output, 200, $headers);
    }

    public function escapeAndReturn($array)
    {
        $str = '';
        foreach ($array as $val) {
            $str .= str_replace(array("\r\n", "\n", "\r", ","), array(" ", " ", " ", " "), $val) . ",";

        }
        return $str;
    }


}