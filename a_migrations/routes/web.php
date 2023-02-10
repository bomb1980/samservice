<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/survey/{reqform_id}', [App\Http\Controllers\report\surveyController::class, 'survey'])->name('survey');

Route::get('loginbyname', [App\Http\Controllers\Auth\LoginController::class, 'loginbyname'])->name('api.auth.checkUsername');


Route::group(['prefix' => 'test'], function () {

    Route::get('/show_per_personal', [App\Http\Controllers\testController::class, 'show_per_personal'])->name('test.show_per_personal');
    Route::get('/index', [App\Http\Controllers\testController::class, 'index'])->name('test.index');
    Route::get('/show_route', [App\Http\Controllers\testController::class, 'show_route'])->name('test.show_route');
    Route::get('/select_area_example', [App\Http\Controllers\testController::class, 'select_area_example'])->name('test.show_route');
    Route::get('/get_request', [App\Http\Controllers\testController::class, 'get_request'])->name('test.get_request');
    // Route::get('/get_request', [App\Http\Controllers\testController::class, 'get_request'])->name('test.get_request');
});


Route::get('/clean_me', function () {
    Artisan::call('config:clear');
});


Route::group(['middleware' => 'auth'], function () {


    Route::get('/', [App\Http\Controllers\report\Dashboard3Controller::class, 'index'])->name('home');
    Route::get('/home', [App\Http\Controllers\report\Dashboard3Controller::class, 'index']);
    Route::get('/dashboard', [App\Http\Controllers\report\Dashboard3Controller::class, 'index'])->name('dashboard');

    // สำหรับ ทุกคนที่ login success


    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    // Route::get('/report/dashboard2', [App\Http\Controllers\report\Dashboard2Controller::class, 'index'])->name('report.dashboard2.index');
    // Route::get('/report/dashboard3', [App\Http\Controllers\report\Dashboard3Controller::class, 'index'])->name('report.dashboard3.index');
    // Route::get('/report/dashboard4', [App\Http\Controllers\report\Dashboard3Controller::class, 'repoer4'])->name('report.dashboard4.index');
    // Route::get('/report/dashboard5', [App\Http\Controllers\report\Dashboard3Controller::class, 'repoer5'])->name('report.dashboard5.index');

    // สำหรับ admin super admin เท่านั้น นะจ๊ะ

    // Route::group(['middleware' => 'role:ROLE_SuperAdmin,ROLE_Admin'], function () {
    // Route::group(['middleware' => 'user'], function () {


    Route::get('/master/fiscalyear', [App\Http\Controllers\Master\FiscalyearController::class, 'index'])->name('master.fiscalyear.index');
    Route::get('/master/fiscalyear/create', [App\Http\Controllers\Master\FiscalyearController::class, 'create'])->name('master.fiscalyear.create');
    Route::get('/master/fiscalyear/{id}/edit', [App\Http\Controllers\Master\FiscalyearController::class, 'edit'])->name('master.fiscalyear.edit');
    Route::delete('/master/fiscalyear/{id}', [App\Http\Controllers\Master\FiscalyearController::class, 'destroy'])->name('master.fiscalyear.destroy');


    Route::get('/master/coursegroup', [App\Http\Controllers\Master\CoursegroupController::class, 'index'])->name('master.coursegroup.index');
    Route::get('/master/coursegroup/create', [App\Http\Controllers\Master\CoursegroupController::class, 'create'])->name('master.coursegroup.create');
    Route::get('/master/coursegroup/{id}/edit', [App\Http\Controllers\Master\CoursegroupController::class, 'edit'])->name('master.coursegroup.edit');
    Route::delete('/master/coursegroup/{id}', [App\Http\Controllers\Master\CoursegroupController::class, 'destroy'])->name('master.coursegroup.destroy');

    Route::get('/master/coursesubgroup', [App\Http\Controllers\Master\CoursesubgroupController::class, 'index'])->name('master.coursesubgroup.index');
    Route::get('/master/coursesubgroup/create', [App\Http\Controllers\Master\CoursesubgroupController::class, 'create'])->name('master.coursesubgroup.create');
    Route::get('/master/coursesubgroup/{id}/edit', [App\Http\Controllers\Master\CoursesubgroupController::class, 'edit'])->name('master.coursesubgroup.edit');
    Route::delete('/master/coursesubgroup/{id}', [App\Http\Controllers\Master\CoursesubgroupController::class, 'destroy'])->name('master.coursesubgroup.destroy');


    Route::get('/master/ownertype', [App\Http\Controllers\Master\OwnertypeController::class, 'index'])->name('master.ownertype.index');
    Route::get('/master/ownertype/create', [App\Http\Controllers\Master\OwnertypeController::class, 'create'])->name('master.ownertype.create');
    Route::get('/master/ownertype/{id}/edit', [App\Http\Controllers\Master\OwnertypeController::class, 'edit'])->name('master.ownertype.edit');
    Route::delete('/master/ownertype/{id}', [App\Http\Controllers\Master\OwnertypeController::class, 'destroy'])->name('master.ownertype.destroy');

    Route::get('/master/buildingtype', [App\Http\Controllers\Master\BuildingtypeController::class, 'index'])->name('master.buildingtype.index');
    Route::get('/master/buildingtype/create', [App\Http\Controllers\Master\BuildingtypeController::class, 'create'])->name('master.buildingtype.create');
    Route::get('/master/buildingtype/{id}/edit', [App\Http\Controllers\Master\BuildingtypeController::class, 'edit'])->name('master.buildingtype.edit');
    Route::delete('/master/buildingtype/{id}', [App\Http\Controllers\Master\BuildingtypeController::class, 'destroy'])->name('master.buildingtype.destroy');


    Route::get('/master/troubletype', [App\Http\Controllers\Master\TroubletypeController::class, 'index'])->name('master.troubletype.index');
    Route::get('/master/troubletype/create', [App\Http\Controllers\Master\TroubletypeController::class, 'create'])->name('master.troubletype.create');
    Route::get('/master/troubletype/{id}/edit', [App\Http\Controllers\Master\TroubletypeController::class, 'edit'])->name('master.troubletype.edit');
    Route::delete('/master/troubletype/{id}', [App\Http\Controllers\Master\TroubletypeController::class, 'destroy'])->name('master.troubletype.destroy');

    Route::get('/master/assessment_topic', [App\Http\Controllers\Master\AssessmentTopicController::class, 'index'])->name('master.assessment_topic.index');
    Route::get('/master/assessment_topic/create', [App\Http\Controllers\Master\AssessmentTopicController::class, 'create'])->name('master.assessment_topic.create');
    Route::get('/master/assessment_topic/{assessment_topics_id}/edit', [App\Http\Controllers\Master\AssessmentTopicController::class, 'edit'])->name('master.assessment_topic.edit');
    Route::delete('/master/assessment_topic/{assessment_topics_id}', [App\Http\Controllers\Master\AssessmentTopicController::class, 'destroy'])->name('master.assessment_topic.destroy');

    Route::get('/master/lecturer', [App\Http\Controllers\Master\LecturerController::class, 'index'])->name('master.lecturer.index');
    Route::get('/master/lecturer/create', [App\Http\Controllers\Master\LecturerController::class, 'create'])->name('master.lecturer.create');
    Route::get('/master/lecturer/{id}/edit', [App\Http\Controllers\Master\LecturerController::class, 'edit'])->name('master.lecturer.edit');
    Route::delete('/master/lecturer/{id}', [App\Http\Controllers\Master\LecturerController::class, 'destroy'])->name('master.lecturer.destroy');


    Route::get('/report1', [App\Http\Controllers\report\Dashboard3Controller::class, 'report1'])->name('report1');
    Route::get('/report2', [App\Http\Controllers\report\Dashboard3Controller::class, 'report2'])->name('report2');
    Route::get('/report3', [App\Http\Controllers\report\Dashboard3Controller::class, 'report3'])->name('report3');
    Route::get('/report/dashboard1', [App\Http\Controllers\report\Dashboard1Controller::class, 'index'])->name('report.dashboard1.index');
    Route::get('/report/dashboard1/pdf', [App\Http\Controllers\report\pdf\dashboardPdfController::class, 'pdf'])->name('report.dashboard1.pdf');
    Route::get('/report/dashboard6', [App\Http\Controllers\report\Dashboard6Controller::class, 'index'])->name('report.dashboard6.index');

    Route::get('/report6', [App\Http\Controllers\report\Dashboard3Controller::class, 'repoer6'])->name('report6');
    Route::get('/report7', [App\Http\Controllers\report\Dashboard3Controller::class, 'report7'])->name('report7');
    Route::get('/report8', [App\Http\Controllers\report\Dashboard3Controller::class, 'report8'])->name('report8');
    Route::get('/report9', [App\Http\Controllers\report\Dashboard3Controller::class, 'report9'])->name('report9');


    Route::get('/permission_list', [App\Http\Controllers\Permission\PermissionController::class, 'index'])->name('permission.index');
    Route::get('/permission/create', [App\Http\Controllers\Permission\PermissionController::class, 'create'])->name('permission.create');
    Route::get('permission/{id}/edit', [App\Http\Controllers\Permission\PermissionController::class, 'edit'])->name('permission.edit');
    Route::get('permission/{id}/status', [App\Http\Controllers\Permission\PermissionController::class, 'status'])->name('permission.status');
    Route::delete('permission/{id}', [App\Http\Controllers\Permission\PermissionController::class, 'destroy'])->name('permission.delete');

    Route::get('/grouppermission/create', [App\Http\Controllers\Permission\GroupPermissionController::class, 'index'])->name('grouppermission.index');



    Route::get('/master/poptype', [App\Http\Controllers\Master\PopulationTypesController::class, 'index'])->name('master.poptype.index');
    Route::get('/master/poptype/create', [App\Http\Controllers\Master\PopulationTypesController::class, 'create'])->name('master.poptype.create');
    Route::get('/master/poptype/{id}/edit', [App\Http\Controllers\Master\PopulationTypesController::class, 'edit'])->name('master.poptype.edit');
    Route::delete('/master/poptype/{id}', [App\Http\Controllers\Master\PopulationTypesController::class, 'destroy'])->name('master.poptype.destroy');


    Route::get('/master/acttype', [App\Http\Controllers\Master\ActtypeTypesController::class, 'index'])->name('master.acttype.index');
    Route::get('/master/acttype/create', [App\Http\Controllers\Master\ActtypeTypesController::class, 'create'])->name('master.acttype.create');
    Route::get('/master/acttype/{id}/edit', [App\Http\Controllers\Master\ActtypeTypesController::class, 'edit'])->name('master.acttype.edit');
    Route::delete('/master/acttype/{id}', [App\Http\Controllers\Master\ActtypeTypesController::class, 'destroy'])->name('master.acttype.destroy');

    Route::get('/master/satisfactionform', [App\Http\Controllers\Master\SatisfactionformController::class, 'index'])->name('master.satisfactionform.index');
    Route::get('/master/satisfactionform/create', [App\Http\Controllers\Master\SatisfactionformController::class, 'create'])->name('master.satisfactionform.create');
    Route::get('/master/satisfactionform/{satisfactionform_id}/edit', [App\Http\Controllers\Master\SatisfactionformController::class, 'edit'])->name('master.satisfactionform.edit');
    Route::delete('/master/satisfactionform/{satisfactionform_id}', [App\Http\Controllers\Master\SatisfactionformController::class, 'destroy'])->name('master.satisfactionform.destroy');

    Route::get('/master/activitytype', [App\Http\Controllers\Master\ActivitytypeController::class, 'index'])->name('master.activitytype.index');
    Route::get('/master/activitytype/create', [App\Http\Controllers\Master\ActivitytypeController::class, 'create'])->name('master.activitytype.create');
    Route::get('/master/activitytype/{activity_types_id}/edit', [App\Http\Controllers\Master\ActivitytypeController::class, 'edit'])->name('master.activitytype.edit');
    Route::delete('/master/activitytype/{activity_types_id}', [App\Http\Controllers\Master\ActivitytypeController::class, 'destroy'])->name('master.activitytype.destroy');

    Route::get('/master/assessmenttype', [App\Http\Controllers\Master\AssessmenttypeController::class, 'index'])->name('master.assessmenttype.index');
    Route::get('/master/assessmenttype/create', [App\Http\Controllers\Master\AssessmenttypeController::class, 'create'])->name('master.assessmenttype.create');
    Route::get('/master/assessmenttype/{assessment_types_id}/edit', [App\Http\Controllers\Master\AssessmenttypeController::class, 'edit'])->name('master.assessmenttype.edit');
    Route::delete('/master/assessmenttype/{assessment_types_id}', [App\Http\Controllers\Master\AssessmenttypeController::class, 'destroy'])->name('master.assessmenttype.destroy');
    // });




    // Route::group(['middleware' => 'user'], function () {

    Route::get('/master/course', [App\Http\Controllers\Master\CourseController::class, 'index'])->name('master.course.index');
    Route::get('/master/course/create', [App\Http\Controllers\Master\CourseController::class, 'create'])->name('master.course.create');
    Route::get('/master/course/{id}/edit', [App\Http\Controllers\Master\CourseController::class, 'edit'])->name('master.course.edit');
    Route::delete('/master/course/{id}', [App\Http\Controllers\Master\CourseController::class, 'destroy'])->name('master.course.destroy');

    // Route::get('/request/request2_1', [App\Http\Controllers\Request\Request2_1Controller::class, 'index'])->name('request.request2_1.index');
    // Route::get('/request/request2_1/create', [App\Http\Controllers\Request\Request2_1Controller::class, 'create'])->name('request.request2_1.create');
    // Route::get('/request/request2_1/{id}/edit', [App\Http\Controllers\Request\Request2_1Controller::class, 'edit'])->name('request.request2_1.edit');

    Route::get('/request/hire', [App\Http\Controllers\Request\RequestHireController::class, 'index'])->name('request.hire.index');

    Route::get('/request/hire/create', [App\Http\Controllers\Request\RequestHireController::class, 'create'])->name('request.hire.create');

    Route::get('/request/hire/{id}/edit', [App\Http\Controllers\Request\RequestHireController::class, 'edit'])->name('request.hire.edit');


    // Route::get('/request/request2_2', [App\Http\Controllers\Request\Request2_2Controller::class, 'index'])->name('request.request2_2.index');
    // Route::get('/request/request2_2/create', [App\Http\Controllers\Request\Request2_2Controller::class, 'create'])->name('request.request2_2.create');
    // Route::get('/request/request2_2/{id}/edit', [App\Http\Controllers\Request\Request2_2Controller::class, 'edit'])->name('request.request2_2.edit');

    Route::get('/request/train', [App\Http\Controllers\Request\RequestTrainController::class, 'index'])->name('request.train.index');
    Route::get('/request/train/create', [App\Http\Controllers\Request\RequestTrainController::class, 'create'])->name('request.train.create');
    Route::get('/request/train/{id}/edit', [App\Http\Controllers\Request\RequestTrainController::class, 'edit'])
        ->name('request.train.edit');

    // Route::get('/request/request2_3', [App\Http\Controllers\Request\Request2_3Controller::class, 'index'])->name('request.request2_3.index');
    Route::get('/request/exel/export/{arr}', [App\Http\Controllers\Request\Exel\RequestExelController::class, 'export'])->name('request.exel.request2_3.index');

    Route::delete('/request/project/{id}', [App\Http\Controllers\Request\RequestProjectController::class, 'destroy'])->name('request.projects.destroy');


    // Route::get('file/view/{files_gen}', [App\Http\Controllers\File\FileController::class, 'view'])->name('file.view');
    // Route::get('file/view_type/{type}/{files_gen}', [App\Http\Controllers\File\FileController::class, 'view_type'])->name('file.view_type');


    Route::get('/master/cmleader', [App\Http\Controllers\Master\CmleaderController::class, 'index'])->name('master.cmleader.index');
    Route::get('/master/cmleader/create', [App\Http\Controllers\Master\CmleaderController::class, 'create'])->name('master.cmleader.create');
    Route::get('/master/cmleader/{id}/edit', [App\Http\Controllers\Master\CmleaderController::class, 'edit'])->name('master.cmleader.edit');
    Route::delete('/master/cmleader/{id}', [App\Http\Controllers\Master\CmleaderController::class, 'destroy'])->name('master.cmleader.destroy');

    Route::get('/master/form', [App\Http\Controllers\Master\SatisfactionSurveyController::class, 'index'])->name('master.form.index');
    Route::get('/master/form/view/{assess_templateno}', [App\Http\Controllers\Master\SatisfactionSurveyController::class, 'view'])->name('master.form.view');
    Route::get('/master/form/create', [App\Http\Controllers\Master\SatisfactionSurveyController::class, 'create'])->name('master.form.create');
    // Route::get('/master/form/edit/{assess_templateno}', [App\Http\Controllers\Master\SatisfactionSurveyController::class, 'edit'])->name('master.form.edit');
    Route::get('/master/form/{assessment_topics_id}/edit', [App\Http\Controllers\Master\SatisfactionSurveyController::class, 'edit'])->name('master.form.edit');
    Route::delete('/master/form/{assessment_topics_id}', [App\Http\Controllers\Master\SatisfactionSurveyController::class, 'destroy'])->name('master.form.destroy');

    // Route::get('/request/reqform', [App\Http\Controllers\Request\ReqformController::class, 'index'])->name('request.reqform.index');

    // Route::get('/request/request3_1', [App\Http\Controllers\Request\Request3_1Controller::class, 'index'])->name('request.request3.request3_1.index');
    // Route::get('/request/request3_1/{id}/edit', [App\Http\Controllers\Request\Request3_1Controller::class, 'edit'])->name('request.request3.request3_1.edit');

    // Route::get('/request/request3_2', [App\Http\Controllers\Request\Request3_2Controller::class, 'index'])->name('request.request3.request3_2.index');
    // Route::get('/request/request3_2/{id}/edit', [App\Http\Controllers\Request\Request3_2Controller::class, 'edit'])->name('request.request3.request3_2.edit');

    // Route::get('/request/request3_3', [App\Http\Controllers\Request\Request3_3Controller::class, 'index'])->name('request.request3.request3_3.index');
    // Route::get('/request/request3_3/{acttype_id}/{id}/detail', [App\Http\Controllers\Request\Request3_3Controller::class, 'detail'])->name('request.request3.request3_3.detail');

    Route::get('/request/consider/{acttype_id}/{id}/detail', [App\Http\Controllers\Request\RequestConsiderController::class, 'detail'])->name('request.consider.detail');


    Route::get('/request/sum_list/{id}/save', [App\Http\Controllers\Request\Sum_ListController::class, 'save'])->name('request.sum_list.save');

    Route::get('/request/sum_list', [App\Http\Controllers\Request\Sum_ListController::class, 'index'])->name('request.sum_list.index');



    Route::get('/manage/fiscalcenter', [App\Http\Controllers\Manage\FiscalcenterController::class, 'index'])->name('manage.fiscalcenter.index');



    Route::get('/manage/receivetransfer/index', [App\Http\Controllers\Manage\ReceivetransferController::class, 'index'])->name('manage.receivetransfer.index');
    Route::get('/manage/receivetransfer/{delete_budget_id}/select_del', [App\Http\Controllers\Manage\ReceivetransferController::class, 'index'])->name('manage.receivetransfer.select_del');

    Route::get('/manage/receivetransfer/create', [App\Http\Controllers\Manage\ReceivetransferController::class, 'create'])->name('manage.receivetransfer.create');
    Route::get('/manage/receivetransfer/{budget_id}/edit', [App\Http\Controllers\Manage\ReceivetransferController::class, 'edit'])->name('manage.receivetransfer.edit');
    Route::delete('/manage/receivetransfer/{id}/delete', [App\Http\Controllers\Manage\ReceivetransferController::class, 'destroy'])->name('manage.receivetransfer.destroy');

    Route::get('/manage/allocate/create', [App\Http\Controllers\Manage\AllocateController::class, 'create'])->name('manage.allocate.create');

    Route::get('/manage/local_mng', [App\Http\Controllers\Manage\local_mng\LocalMngController::class, 'index'])->name('manage.local_mng.index');
    Route::get('/manage/local_mng/{fiscalyear_code}/edit', [App\Http\Controllers\Manage\local_mng\LocalMngController::class, 'edit'])->name('manage.local_mng.edit');
    Route::get('/manage/local_mng/tranbackcen', [App\Http\Controllers\Manage\local_mng\LocalMngController::class, 'tranback'])->name('manage.local_mng.tranbackcen');
    Route::delete('/manage/local_mng/{id}/delete', [App\Http\Controllers\Manage\local_mng\LocalMngController::class, 'destroy'])->name('manage.local_mng..destroy');

    Route::get('/activity/ready_confirm', [App\Http\Controllers\activity\ready_confirm\Ready_ConfirmController::class, 'index'])->name('activity.ready_confirm.index');
    Route::get('/activity/ready_confirm/copy', [App\Http\Controllers\activity\ready_confirm\Ready_ConfirmController::class, 'act_copy'])->name('activity.ready_confirm.copy');
    Route::get('/activity/ready_confirm/list', [App\Http\Controllers\activity\ready_confirm\Ready_ConfirmController::class, 'list'])->name('activity.ready_confirm.list');
    Route::get('/activity/ready_confirm/hire/create', [App\Http\Controllers\activity\ready_confirm\Ready_ConfirmController::class, 'hire_create'])->name('activity.ready_confirm.hire.create');
    Route::get('/activity/ready_confirm/hire/{id}/edit', [App\Http\Controllers\activity\ready_confirm\Ready_ConfirmController::class, 'hire_edit'])->name('activity.ready_confirm.hire.edit');
    Route::get('/activity/ready_confirm/train/create', [App\Http\Controllers\activity\ready_confirm\Ready_ConfirmController::class, 'train_create'])->name('activity.ready_confirm.train.create');
    Route::get('/activity/ready_confirm/train/{id}/edit', [App\Http\Controllers\activity\ready_confirm\Ready_ConfirmController::class, 'train_edit'])->name('activity.ready_confirm.train.edit');
    Route::delete('/activity/ready_confirm/{id}', [App\Http\Controllers\activity\ready_confirm\Ready_ConfirmController::class, 'destroy'])->name('activity.ready_confirm.destroy');

    Route::get('/activity/tran_mng', [App\Http\Controllers\activity\tran_mng\Tran_MngController::class, 'index'])->name('activity.tran_mng.index');
    Route::get('/activity/tran_mng/manage', [App\Http\Controllers\activity\tran_mng\Tran_MngController::class, 'manage'])->name('activity.tran_mng.manage');
    Route::get('/activity/tran_mng/transfer', [App\Http\Controllers\activity\tran_mng\Tran_MngController::class, 'transfer'])->name('activity.tran_mng.transfer');
    Route::get('/activity/tran_mng/allocate/{id}', [App\Http\Controllers\activity\tran_mng\Tran_MngController::class, 'allocate'])->name('activity.tran_mng.allocate');
    Route::get('/activity/tran_mng/allocate/{id}/edit', [App\Http\Controllers\activity\tran_mng\Tran_MngController::class, 'allocate_edit'])->name('activity.tran_mng.allocate.edit');

    Route::get('/activity/plan_adjust', [App\Http\Controllers\activity\plan_adjust\Plan_AdjustController::class, 'index'])->name('activity.plan_adjust.index');
    Route::get('/activity/plan_adjust/hire', [App\Http\Controllers\activity\plan_adjust\Plan_AdjustController::class, 'hire'])->name('activity.plan_adjust.hire');
    Route::get('/activity/plan_adjust/hire/{id}/edit', [App\Http\Controllers\activity\plan_adjust\Plan_AdjustController::class, 'edit_hire'])->name('activity.plan_adjust.hire.edit');
    Route::get('/activity/plan_adjust/train', [App\Http\Controllers\activity\plan_adjust\Plan_AdjustController::class, 'train'])->name('activity.plan_adjust.train');
    Route::get('/activity/plan_adjust/train/{id}/edit', [App\Http\Controllers\activity\plan_adjust\Plan_AdjustController::class, 'edit_train'])->name('activity.plan_adjust.train.edit');

    Route::get('/activity/act_detail', [App\Http\Controllers\activity\act_detail\Act_DetailController::class, 'index'])->name('activity.act_detail.index');
    Route::get('/activity/act_detail/{act_id}/create', [App\Http\Controllers\activity\act_detail\Act_DetailController::class, 'create'])->name('activity.act_detail.create');

    Route::get('/activity/other_expense', [App\Http\Controllers\activity\other_expense\OtherExpenseController::class, 'index'])->name('activity.other_expense.index');
    Route::get('/activity/other_expense/create', [App\Http\Controllers\activity\other_expense\OtherExpenseController::class, 'create'])->name('activity.other_expense.create');

    Route::get('/activity/activity_image', [App\Http\Controllers\activity\activity_image\ActivityImageController::class, 'index'])->name('activity.activity_image.index');
    Route::get('/activity/activity_image/create', [App\Http\Controllers\activity\activity_image\ActivityImageController::class, 'create'])->name('activity.activity_image.create');
    Route::get('/activity/activity_image/images', [App\Http\Controllers\activity\activity_image\ActivityImageController::class, 'images'])->name('activity.activity_image.images');

    Route::get('/activity/assessment', [App\Http\Controllers\activity\assessment\AssessmentController::class, 'index'])->name('activity.assessment.index');
    Route::get('/activity/assessment/create', [App\Http\Controllers\activity\assessment\AssessmentController::class, 'create'])->name('activity.assessment.create');


    Route::get('/activity/participant', [App\Http\Controllers\activity\participant\ParticipantController::class, 'index'])->name('activity.participant.index');
    Route::get('/activity/participant/create/{reqform_id}', [App\Http\Controllers\activity\participant\ParticipantController::class, 'create'])->name('activity.participant.create');

    Route::get('/activity/summary_expenses', [App\Http\Controllers\activity\summary_expenses\SummaryExpensesController::class, 'index'])->name('activity.summary_expenses.index');
    Route::get('/activity/summary_expensesyear', [App\Http\Controllers\activity\summary_expenses\SummaryExpensesYearController::class, 'index'])->name('activity.summary_expensesyear.index');



    Route::get('/activity/join_activity', [App\Http\Controllers\activity\join_activity\JoinActivityController::class, 'index'])->name('activity.join_activity.index');
    Route::get('/activity/join_activity/create', [App\Http\Controllers\activity\join_activity\JoinActivityController::class, 'create'])->name('activity.join_activity.create');



    Route::get('/activity/recordattendance', [App\Http\Controllers\activity\assessment\RecordattendanceController::class, 'index'])->name('activity.recordattendance.index');
    // Route::get('/activity/recordattendance/create/{act_id}', [App\Http\Controllers\activity\assessment\RecordattendanceController::class, 'create'])->name('activity.recordattendance.create');
    Route::get('/activity/recordattendance/create/{reqform_id}', [App\Http\Controllers\activity\assessment\RecordattendanceController::class, 'create'])->name('activity.recordattendance.create');

    Route::get('/operate', [App\Http\Controllers\activity\operate\OperateController::class, 'index'])->name('operate.index');
    Route::get('/operate/result_train/{id}/{p_id}', [App\Http\Controllers\activity\operate\OperateController::class, 'result_train'])->name('operate.result_train.detail');
    Route::get('/operate/emer_employ/{id}/{p_id}', [App\Http\Controllers\activity\operate\OperateController::class, 'emer_employ'])->name('operate.emer_employ.detail');


    Route::get('/population/{act_id}/{act_number}/create/{role}', [App\Http\Controllers\activity\operate\population\PopulationController::class, 'create'])->name('population.create');
    Route::get('/population/{act_id}/{id}/edit', [App\Http\Controllers\activity\operate\population\PopulationController::class, 'edit'])->name('population.edit');

    Route::get('/population/lecturer/{act_id}/create', [App\Http\Controllers\activity\operate\population\PopulationController::class, 'create_lecturer'])->name('population.create_lecturer');



    Route::get('/master/estimate', [App\Http\Controllers\Master\EstimateActivityController::class, 'index'])->name('master.estimate.index');
    Route::get('/master/estimate/create', [App\Http\Controllers\Master\EstimateActivityController::class, 'create'])->name('master.estimate.create');
    Route::get('/master/estimate/{id}/edit', [App\Http\Controllers\Master\EstimateActivityController::class, 'edit'])->name('master.estimate.edit');
    Route::delete('/master/estimate/{id}', [App\Http\Controllers\Master\EstimateActivityController::class, 'destroy'])->name('master.estimate.destroy');


    Route::get('/manage/center', [App\Http\Controllers\Manage\cen_depo\Cen_DepoController::class, 'index'])->name('manage.center');
    Route::get('/manage/upcountry', [App\Http\Controllers\Manage\cen_depo\Cen_DepoController::class, 'upcountry'])->name('manage.upcountry');
    Route::get('/manage/center/{id}/save', [App\Http\Controllers\Manage\cen_depo\Cen_DepoController::class, 'save'])->name('manage.cen_depo.save');
    Route::get('/manage/center/{id}/save/upcountry', [App\Http\Controllers\Manage\cen_depo\Cen_DepoController::class, 'save_upcountry'])->name('manage.cen_depo.save.upcountry');

    Route::get('/manage/follow_budget/index', [App\Http\Controllers\Manage\follow_budgetController::class, 'index'])->name('manage.follow_budget.index');




    Route::get('/history', [App\Http\Controllers\HistoryController::class, 'history'])->name('history');

    Route::get('/notifications', [App\Http\Controllers\NotificationsController::class, 'notifications'])->name('notifications');
    Route::post('/readNoti', [App\Http\Controllers\NotificationsController::class, 'readNoti'])->name('readNoti');


    Route::get('/manage/fiscalyear_cls', [App\Http\Controllers\Master\FiscalyearController::class, 'cls_list'])->name('manage.fiscalyear_cls.index');

    Route::get('/manage/fiscalyear_cls/{id}', [App\Http\Controllers\Master\FiscalyearController::class, 'closeYear'])->name('manage.fiscalyear_cls.save');


    // });

    // Route::get('/notfound', [App\Http\Controllers\Master\FiscalyearController::class, 'notfound'])->name('notfound');

    Route::get('/notfound', [App\Http\Controllers\Request\RequestHireController::class, 'notfound'])->name('notfound');

    Route::get('/manage/fiscal', [App\Http\Controllers\Manage\FiscalController::class, 'index'])->name('manage.fiscal.index');
    Route::get('/manage/fiscal2', [App\Http\Controllers\Manage\FiscalController::class, 'index2'])->name('manage.fiscal.index2');
    Route::get('/manage/fiscal/{id}/save', [App\Http\Controllers\Manage\FiscalController::class, 'save'])->name('manage.fiscal.save');
    Route::get('/manage/fiscal/{id}/save2', [App\Http\Controllers\Manage\FiscalController::class, 'save2'])->name('manage.fiscal.save2');


    Route::get('/manage/installment', [App\Http\Controllers\Manage\InstallmentController::class, 'index'])->name('manage.installment.index');
    // Route::get('/manage/installment/create', [App\Http\Controllers\Manage\InstallmentController::class, 'create'])->name('manage.installment.create');
    Route::get('/manage/installment/{year_id}', [App\Http\Controllers\Manage\InstallmentController::class, 'edit'])->name('manage.installment.create');
    Route::get('/manage/installment/{year_id}/{budget_id}', [App\Http\Controllers\Manage\InstallmentController::class, 'edit'])->name('manage.installment.edit');

    Route::get('/request/project', [App\Http\Controllers\Request\RequestProjectController::class, 'index'])->name('request.projects.index');
    Route::get('/request/consider', [App\Http\Controllers\Request\RequestConsiderController::class, 'index'])->name('request.consider.index');

});

Route::get('/qrcode/{act_id}/form/{p_id}', [App\Http\Controllers\activity\operate\QrcodeController::class, 'qrcode'])->name('assessment_qrcode');
Route::get('/assessment_form/{act_id}/form/{p_id}', [App\Http\Controllers\activity\operate\QrcodeController::class, 'assessment_form'])->name('activity.operate.assessment_form');

Route::get('/master/coursetype', [App\Http\Controllers\Master\CoursetypeController::class, 'index'])->name('master.coursetype.index');
Route::get('/master/coursetype/create', [App\Http\Controllers\Master\CoursetypeController::class, 'create'])->name('master.coursetype.create');
Route::get('/master/coursetype/{id}/edit', [App\Http\Controllers\Master\CoursetypeController::class, 'edit'])->name('master.coursetype.edit');
Route::delete('/master/coursetype/{id}', [App\Http\Controllers\Master\CoursetypeController::class, 'destroy'])->name('master.coursetype.destroy');
