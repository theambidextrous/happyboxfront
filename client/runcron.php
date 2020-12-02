<?php
session_start();
require_once('../lib/Util.php');
require_once('../lib/Sendy.php');
require_once('../lib/Order.php');
$util = new Util();
$sendy = new Sendy($util->MapsKey());
$order = new Order('faketoken');
if (date('N') == 6) {
    /** do not send */
    exit(json_encode([
        'action' => 'Not today'
    ]));
}
$orders_list = $order->run_cron();
//file_put_contents("sendyorderpayload.log", $orders_list.PHP_EOL, FILE_APPEND | LOCK_EX);
$orders_list = json_decode($order->run_cron(), true);
$payload = $orders_list['data'];
if (count($payload)) {
    try {
        foreach ($payload as $_item) :
            $kesho = date('Y-m-d', strtotime('tomorrow')) . ' 08:00';
            $order_user = find_delivery_user($_item['order_meta']);
            $_item['name'] = $order_user[0];
            $_item['phone'] = $order_user[1];
            $_item['qty'] = process_meta($_item['order_meta']);
            $_item['pick_up_date'] = date('Y-m-d H:i:s', strtotime($kesho));
            $sendy_rsp = $sendy->post_fields($_item, $_item['order_id'], $_item['box_voucher']);
            //file_put_contents("sendyresponsepayload.log", $sendy_rsp.PHP_EOL, FILE_APPEND | LOCK_EX);
            $sendy_rsp = json_decode($sendy_rsp, true);            
            if ($sendy_rsp['status']) {
                $_body = ['id' => $_item['id'], 'is_send' => true, 'sendy_log' => json_encode($sendy_rsp)];
                $update_resp = $order->update_ship_request($_body);
                $util->Show('success:  ' . $update_resp);
            } else {
                $_body = ['id' => $_item['id'], 'is_send' => false, 'sendy_log' => json_encode($sendy_rsp)];
                $update_resp = $order->update_ship_request($_body);
                $util->Show('fail:  ' . $update_resp);
            }
        endforeach;
    } catch (Exception $e) {
        print $e->getMessage();
    }
}
function process_meta($in) {
    $in = json_decode($in, true);
    $qty = [];
    foreach ($in as $_p) {
        if (isset($_p['order_id'])) {
        } elseif (isset($_p['physical_address'])) {
        } else {
            if ($_p[2] != 2) {
                /** pbox */
                array_push($qty, $_p[1]);
            }
        }
    }
    return array_sum($qty);
}
function find_delivery_user($in) {
    $in = json_decode($in, true);
    $address = $in[2000]['physical_address'];
    $name = $address[0];
    $phone = $address[6];
    return [$name, $phone];
}
