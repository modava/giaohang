<?php

namespace modava\giaohang;


class GiaoHangTietKiem
{
    /*
     * Host giao hang tiet kiem
     */
    private $host = 'services.giaohangtietkiem.vn';

    /*
     * Token
     */
    // public $token = '0c786A5454FfEdc5308a67c5C1273241b0A90c8d';
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /*
     * Tính phí vận chuyển
     * @param : data
     * https://docs.giaohangtietkiem.vn/?php#t-nh-ph-v-n-chuy-n
     */
    public function shipmentFee($data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->host . "/services/shipment/fee?" . http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => [
                "Token: " . $this->token,
            ],
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /*
     * Trạng thái đơn hàng
     * @param : order_no 
     * https://docs.giaohangtietkiem.vn/?php#tr-ng-th-i-n-h-ng
     */
    public function shipmentOrder($order_no)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->host . "/services/shipment/v2/" . $order_no,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => [
                "Token: " . $this->token,
            ],
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /*
     * Đăng đơn hàng 
     * @param : order
     * https://docs.giaohangtietkiem.vn/?php#ng-n-h-ng
     */
    public function createShipmentOrder($order)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->host . "/services/shipment/order",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $order,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Token: " . $this->token,
                "Content-Length: " . strlen($order),
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /*
     * Hủy đơn hàng
     * https://docs.giaohangtietkiem.vn/?php#h-y-n-h-ng
     */
    public function cancelOrder($order_no)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->host . "/services/shipment/cancel/" . $order_no,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => [
                "Token: " . $this->token,
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /*
     * In đơn hàng
     * https://docs.giaohangtietkiem.vn/?php#in-nh-n-n-h-ng
     */
    public function printOrder($order_no)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->host . "/services/label/" . $order_no,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => [
                "Token: " . $this->token,
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        header("Content-Disposition:attachment;filename=" . $order_no . ".pdf");
        echo $response;
    }
}
