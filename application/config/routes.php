<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

// Admin Controller
$route['backend']                                       = 'admin/login';
$route['backend/authenticate']                          = 'admin/login/authenticate';
$route['backend/logout']                                = 'admin/login/logout';

// Dashboard
$route['backend/dashboard']                            = 'admin/dashboard';

//Re-ordering
$route['backend/re-ordering/(:any)/(:any)']            = 'admin/extra/reOrdering/$1/$2';

// Board
$route['backend/board']                                = 'admin/board';
$route['backend/board/store']                          = 'admin/board/store';
$route['backend/board/edit/(:num)']                    = 'admin/board/edit/$1';
$route['backend/board/update/(:num)']                  = 'admin/board/update/$1';
$route['backend/board/remove/(:num)']                  = 'admin/board/remove/$1';
$route['backend/board/removeSelected']                 = 'admin/board/removeSelected';
$route['backend/board/status/(:num)/(:num)']           = 'admin/board/status/$1/$2';

// Standards
$route['backend/standard']                              = 'admin/standard';
$route['backend/standard/store']                        = 'admin/standard/store';
$route['backend/standard/edit/(:num)']                  = 'admin/standard/edit/$1';
$route['backend/standard/update/(:num)']                = 'admin/standard/update/$1';
$route['backend/standard/remove/(:num)']                = 'admin/standard/remove/$1';
$route['backend/standard/status/(:num)/(:num)']         = 'admin/standard/status/$1/$2';
$route['backend/standard/removeSelected']               = 'admin/standard/removeSelected';
// Subjects
$route['backend/subject']                               = 'admin/subject';
$route['backend/subject/store']                         = 'admin/subject/store';
$route['backend/subject/edit/(:any)']                   = 'admin/subject/edit/$1';
$route['backend/subject/update/(:num)']                 = 'admin/subject/update/$1';
$route['backend/subject/remove/(:num)']                 = 'admin/subject/remove/$1';
$route['backend/subject/status/(:num)/(:num)']          = 'admin/subject/status/$1/$2';
$route['backend/subject/removeSelected']                = 'admin/subject/removeSelected';

// chapter
$route['backend/chapter']                               = 'admin/chapter';
$route['backend/chapter/store']                         = 'admin/chapter/store';
$route['backend/chapter/edit/(:any)']                   = 'admin/chapter/edit/$1';
$route['backend/chapter/update/(:num)']                 = 'admin/chapter/update/$1';
$route['backend/chapter/remove/(:num)']                 = 'admin/chapter/remove/$1';
$route['backend/chapter/removeSelected']                = 'admin/chapter/removeSelected';
$route['backend/chapter/status/(:num)/(:num)']          = 'admin/chapter/status/$1/$2';

// topic
$route['backend/topic']                               = 'admin/topic';
$route['backend/topic/create']                        = 'admin/topic/create';
$route['backend/topic/store']                         = 'admin/topic/store';
$route['backend/topic/edit/(:any)']                   = 'admin/topic/edit/$1';
$route['backend/topic/update/(:num)']                 = 'admin/topic/update/$1';
$route['backend/topic/remove/(:num)']                 = 'admin/topic/remove/$1';
$route['backend/topic/removeSelected']                = 'admin/topic/removeSelected';
$route['backend/topic/status/(:num)/(:num)']          = 'admin/topic/status/$1/$2';
$route['backend/topic/copy/(:num)']                   = 'admin/topic/copy/$1';

// subtopics
$route['backend/subtopic']                               = 'admin/subtopic';
$route['backend/subtopic/create']                        = 'admin/subtopic/create';
$route['backend/subtopic/store']                         = 'admin/subtopic/store';
$route['backend/subtopic/edit/(:any)']                   = 'admin/subtopic/edit/$1';
$route['backend/subtopic/update/(:num)']                 = 'admin/subtopic/update/$1';
$route['backend/subtopic/remove/(:num)']                 = 'admin/subtopic/remove/$1';
$route['backend/subtopic/removeSelected']                 = 'admin/subtopic/removeSelected';
$route['backend/subtopic/status/(:num)/(:num)']          = 'admin/subtopic/status/$1/$2';
$route['backend/subtopic/copy/(:num)']                = 'admin/subtopic/copy/$1';

// Method example
$route['backend/example']                            = 'admin/example';
$route['backend/example/create']                     = 'admin/example/create';
$route['backend/example/store']                      = 'admin/example/store';
$route['backend/example/show/(:num)']                = 'admin/example/show/$1';
$route['backend/example/view']		                 = 'admin/example/view';
$route['backend/example/edit/(:num)']                = 'admin/example/edit/$1';
$route['backend/example/update/(:num)']              = 'admin/example/update/$1';
$route['backend/example/status/(:num)/(:num)']       = 'admin/example/status/$1/$2';
$route['backend/example/remove/(:num)']              = 'admin/example/remove/$1';
$route['backend/example/copy/(:num)']                = 'admin/example/copy/$1';
$route['backend/example/removeSelected']             = 'admin/example/removeSelected';
$route['backend/removeQuestion/(:num)']              = 'admin/example/removeQuestion/$1';
$route['backend/removeQuestionItem/(:num)']          = 'admin/example/removeQuestionItem/$1';
$route['backend/removeAnswerItem/(:num)']            = 'admin/example/removeAnswerItem/$1';

//Setting
$route['backend/setting']               			 = 'admin/setting';
$route['backend/setting/set-gamesound/(:num)']       = 'admin/setting/setGameSound/$1';
$route['backend/setting/set-splashscreen/(:num)']    = 'admin/setting/setSplashScreen/$1';
$route['backend/setting/next_level_details/(:num)']    = 'admin/setting/next_level_details/$1';

// Users
$route['backend/user']                               = 'admin/user';
$route['backend/teacherlist']                        = 'admin/teacherlist/listdata';
$route['backend/teacherlist/edit/(:num)']            = 'admin/teacherlist/edit/$1';
$route['backend/teacherlist/update/(:num)']          = 'admin/teacherlist/update/$1';

// Category
$route['backend/category']                 = 'admin/category';
$route['backend/category/create']          = 'admin/category/create';
$route['backend/category/store']           = 'admin/category/store';
$route['backend/category/edit/(:num)']     = 'admin/category/edit/$1';
$route['backend/category/update/(:num)']   = 'admin/category/update/$1';
$route['backend/category/remove/(:num)']   = 'admin/category/remove/$1';
$route['backend/category/removeSelected']  = 'admin/category/removeSelected';
$route['backend/category/status/(:num)/(:num)'] = 'admin/category/status/$1/$2';

// Layout
$route['backend/layout']                 = 'admin/layout';
$route['backend/layout/create']          = 'admin/layout/create';
$route['backend/layout/store']           = 'admin/layout/store';
$route['backend/layout/edit/(:num)']     = 'admin/layout/edit/$1';
$route['backend/layout/update/(:num)']   = 'admin/layout/update/$1';
$route['backend/layout/remove/(:num)']   = 'admin/layout/remove/$1';
$route['backend/layout/removeSelected']  = 'admin/layout/removeSelected';
$route['backend/layout/status/(:num)/(:num)'] = 'admin/layout/status/$1/$2';

// Syllabus
$route['backend/syllabus']                 = 'admin/syllabus';
$route['backend/syllabus_list']            = 'admin/syllabus/syllabus_list';

// School
$route['backend/school']                 = 'admin/school';
$route['backend/school/create']          = 'admin/school/create';
$route['backend/school/store']           = 'admin/school/store';
$route['backend/school/edit/(:num)']     = 'admin/school/edit/$1';
$route['backend/school/view/(:num)']     = 'admin/school/view/$1';
$route['backend/school/update/(:num)']   = 'admin/school/update/$1';
$route['backend/school/remove/(:num)']   = 'admin/school/remove/$1';
$route['backend/school/removeSelected']  = 'admin/school/removeSelected';

// Teacher
$route['backend/teacher']                = 'admin/teacher';
$route['backend/teacher/store']           = 'admin/teacher/store';

// Subscription Plans
$route['backend/subscription_plans']                 = 'admin/subscription_plans';
$route['backend/subscription_plans/create']          = 'admin/subscription_plans/create';
$route['backend/subscription_plans/store']           = 'admin/subscription_plans/store';
$route['backend/subscription_plans/edit/(:num)']     = 'admin/subscription_plans/edit/$1';
$route['backend/subscription_plans/update/(:num)']   = 'admin/subscription_plans/update/$1';
$route['backend/subscription_plans/status/(:num)/(:num)'] = 'admin/subscription_plans/status/$1/$2';
$route['backend/subscription_plans/remove/(:num)']   = 'admin/subscription_plans/remove/$1';
$route['backend/subscription_plans/removeSelected']  = 'admin/subscription_plans/removeSelected';
$route['backend/subscription']                       = 'admin/subscription';
$route['backend/subscription/remove/(:num)']         = 'admin/subscription/remove/$1';
$route['backend/subscription/removeSelected']        = 'admin/subscription/removeSelected';
$route['backend/plan_type']                          = 'admin/plan_type';
$route['backend/plan_type/create']                   = 'admin/plan_type/create';
$route['backend/plan_type/store']                    = 'admin/plan_type/store';
$route['backend/plan_type/edit/(:num)']              = 'admin/plan_type/edit/$1';
$route['backend/plan_type/update/(:num)']            = 'admin/plan_type/update/$1';
$route['backend/plan_type/remove/(:num)']            = 'admin/plan_type/remove/$1';
$route['backend/plan_type/removeSelected']           = 'admin/plan_type/removeSelected';
$route['backend/subscription_plans/get_plan_type']   = 'admin/subscription_plans/get_plan_type';

// Reports 
$route['backend/reports'] = 'admin/reports';

// teacher dashboard
$route['teachers']                                       = 'teachers/login';
$route['teachers/dashboard']                             = 'teachers/dashboard';
$route['teachers/authenticate']                          = 'teachers/login/authenticate';
$route['teachers/logout']                                = 'teachers/login/logout';




// ============================================= API ==================================================//

$route['test_api']                                      = 'api/home/test_api';
$route['api_splashscreen']                              = 'api/home/splashscreen';
$route['api_game_sound']                                = 'api/home/game_sound';
$route['api_category']                                  = 'api/home/category';
$route['api_privacy_policy']                            = 'api/home/privacy_policy';
$route['api_category']                                  = 'api/home/category';
$route['api_language']                                  = 'api/home/language';
$route['api_board_list']                                = 'api/home/board_list';
$route['api_standard_list']                             = 'api/home/standard_list';
$route['api_subject_list']                              = 'api/home/subject_list';
$route['api_chapter_list']                              = 'api/home/chapter_list';
$route['api_topics_list']                               = 'api/home/topics_list';
$route['api_subtopics_list']                            = 'api/home/subtopics_list';

$route['api_social_login']                              = 'api/auth/social_login';

$route['api_update_profile']                            = 'api/user/update_profile';
$route['api_get_user_profile']                          = 'api/user/get_user_profile';

$route['api_profile']                                   = 'api/user/name_avatar';

$route['api_method_mapping']                            = 'api/example/method_mapping';
$route['api_example_data']                              = 'api/example/example_data';


// Register API
$route['api_register']                                 = 'api/user/register_user';
$route['api_school']                                   = 'api/user/add_school';
$route['api_subscription']                             = 'api/user/add_subscription';
$route['api_subscription_plan']                        = 'api/user/get_subscription_plan';
$route['api_user_achievement']                         = 'api/user/user_achievement';
$route['api_last_week_report']                         = 'api/user/last_week_time';
$route['api_subtopic_time']                            = 'api/user/subtopic_time';
$route['api_user_total_star']                          = 'api/user/get_total_star';
$route['api_school_total_star']                        = 'api/user/get_school_total_star';
$route['api_lock_unlock_example']                      = 'api/user/lock_unlock_example';
$route['api_lock_flag']                                = 'api/user/get_lock_unlock_flag';
$route['api_verify_user']                              = 'api/auth/verify_user';
$route['api_available_licence']                        = 'api/auth/get_available_student';
$route['api_restrict_plan']                            = 'api/user/get_restricted_data';

$route['update_app_usage_time']                        = 'api/cron/update_app_usage_time';
$route['api_student_achievemnet']                      = 'api/user/student_subject_achivement';
$route['api_teacher_subjects']                         = 'api/user/teacher_subject_achivement';
$route['api_social_id_exist']                          = 'api/auth/social_user_exist';
$route['api_paid_link']                                = 'api/user/school_paid_link';

// teacher API
$route['api_school_users']                             = 'api/user/get_school_user';