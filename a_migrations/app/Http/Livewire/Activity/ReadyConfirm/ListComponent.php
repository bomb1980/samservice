<?php

namespace App\Http\Livewire\Activity\ReadyConfirm;

use App\Models\OoapTblFiscalyear;
use App\Models\OoapTblActivities;
use Livewire\Component;

class ListComponent extends Component
{
  public $fiscalyear_list, $fiscalyear_code;
  public $actlist, $select = [], $select_all;

  public function mount()
  {
    $this->fiscalyear_code = 2565;
    $this->fiscalyear_list = OoapTblFiscalyear::where('in_active', '=', false)->pluck('fiscalyear_code', 'fiscalyear_code AS fiscalyear_code2');
    $this->actlist = OoapTblActivities::select(
      'ooap_tbl_activities.act_id',
      'ooap_tbl_activities.act_number',
      'ooap_mas_division.division_name',
      'ooap_tbl_activities.dept_id',
      'ooap_tbl_activities.act_acttype',
      'ooap_mas_acttype.act_shortname',
      'ooap_tbl_activities.act_district',
      'ooap_mas_amphur.amphur_name',
      'ooap_tbl_activities.act_subdistrict',
      'ooap_mas_tambon.tambon_name',
      'ooap_tbl_activities.act_moo',
      'ooap_tbl_activities.act_numofday',
      'ooap_tbl_activities.act_numofpeople',
      'ooap_tbl_activities.act_amount',
      'ooap_tbl_activities.status',
      'ooap_tbl_activities.in_active'
    )
      ->where('ooap_tbl_activities.in_active', '=', false)->where('ooap_tbl_activities.status', '=', 3)
      ->leftjoin('ooap_mas_acttype', 'ooap_tbl_activities.act_acttype', 'ooap_mas_acttype.id')
      ->leftjoin('ooap_mas_amphur', 'ooap_tbl_activities.act_district', 'ooap_mas_amphur.amphur_id')
      ->leftjoin('ooap_mas_tambon', 'ooap_tbl_activities.act_subdistrict', 'ooap_mas_tambon.tambon_id')
      ->leftjoin('ooap_mas_division', 'ooap_tbl_activities.act_div', 'ooap_mas_division.division_id')
      ->get()->toArray();
    $this->select_all = 0;
    foreach ($this->actlist as $key => $val) {
      $this->select[$key] = 0;
    }

    // dd($this->choose);
  }

  public function check_list()
  {
    if ($this->select_all == 0) {
      $this->select = [];
      $this->select_all = 1;
      foreach ($this->actlist as $key => $val) {
        $this->select[$key] = $val['act_id'];
      }
    } elseif ($this->select_all == 1) {
      $this->select = [];
      $this->select_all = 0;
      foreach ($this->actlist as $key => $val) {
        $this->select[$key] = 0;
      }
    }

    // dd($this->select_all);
  }

  public function submit()
  {
    // dd($this->select)/;
    $chack_array = [];
    foreach ($this->select as $key => $reqform_id) {
      if ($reqform_id != 0) {
        $chack_array[] = $reqform_id;
      }
    }
    // dd($chack_array);
    // foreach ($this->select as $key => $reqform_id) {
    $test = OoapTblActivities::whereNotIn('act_id', $chack_array)->where('status', '=', 3)
      // dd($test);
      ->update([
        'in_active' => 1,
        'updated_by' => auth()->user()->emp_citizen_id,
        'updated_at' => now(),
      ]);
    // }
    $this->emit('popup');
  }
  protected $listeners = ['redirect-to' => 'redirect_to'];

  public function redirect_to()
  {
    return redirect()->route('activity.ready_confirm.index');
  }

  public function render()
  {
    return view('livewire.activity.ready-confirm.list-component');
  }
}
