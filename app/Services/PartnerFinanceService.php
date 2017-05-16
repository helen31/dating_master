<?php

namespace App\Services;

use App\Constants;
use App\Models\User;
use App\Models\PartnerFinance;
use App\Models\PartnerTransaction;
use App\Models\ExchangeRate;
use App\Services\ClientFinanceService;


final class PartnerFinanceService
{
    public static function chargePartnersComission($user_id, $girl_id, $type, $present_id = null)
    {
        $partner_id = User::where('id', '=', $girl_id)->first()->partner_id;
        if($partner_id !== 1){
            $price = ClientFinanceService::getServicePrice($type, $present_id);
            $acc_rate = self::getChargeRate($type);
            $exchange_rate_usd = (double)ExchangeRate::where('name', '=', 'lc_usd')->first()->rate;
            $accrual = $price*$acc_rate*$exchange_rate_usd;

            /* Если у партрнера нет счета, создаем его
            и увеличиваем баланс на счету */
            $partner_finances = PartnerFinance::where('partner_id', '=', $partner_id)->first();
            if ($partner_finances === null) {
                $partner_finances = new PartnerFinance();
                $partner_finances->partner_id = $partner_id;
                $partner_finances->amount = $accrual;
                $partner_finances->save();
            } else {
                $partner_finances->amount = $partner_finances->amount + $accrual;
                $partner_finances->save();
            }

            /* Создаем запись о зачислении средств партнеру */
            $new_partner_trans = new PartnerTransaction();
            $new_partner_trans->user_id = $user_id;
            $new_partner_trans->girl_id = $girl_id;
            $new_partner_trans->amount = $accrual;
            $new_partner_trans->type = $type;
            $new_partner_trans->description = null;
            if ($present_id !== null) {
                $new_partner_trans->description = ClientFinanceService::getPresentName($present_id);
            }
            $new_partner_trans->partner_id = $partner_id;

            $new_partner_trans->save();
        }
    }

    public static function getChargeRate($type)
    {
        if ($type == 'gift') {
            $charge_rate = (double)ExchangeRate::where('name', '=', 'acc_gift')->first()->rate;
        } else {
            $charge_rate = (double)ExchangeRate::where('name', '=', 'acc_service')->first()->rate;
        }
        return $charge_rate;
    }


}