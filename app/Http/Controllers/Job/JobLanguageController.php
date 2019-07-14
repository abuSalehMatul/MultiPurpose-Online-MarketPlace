<?php
/**
 * Class LanguageController.
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @link    http://www.amentotech.com
 */

namespace App\Http\Controllers\Job;

use App\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;
use App\JobModel\JobHelper;

/**
 * Class LanguageController
 *
 */
class JobLanguageController extends Controller
{
   
    protected $language;

    
    public function __construct(Language $language)
    {
        $this->language = $language;
    }

   
    public function index()
    {
        if (!empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $langs = $this->language::where('title', 'like', '%' . $keyword . '%')->paginate(7)->setPath('');
            $pagination = $langs->appends(
                array(
                    'keyword' => Input::get('keyword')
                )
            );
        } else {
            $langs = $this->language->paginate(10);
        }
        return View::make(
            'job.back-end.admin.languages.index',
            compact('langs')
        );
    }

   
    public function store(Request $request)
    {
        $server_verification = JobHelper::worketicIsDemoSite();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $this->validate(
            $request, [
                'language_title' => 'required',
            ]
        );
        $this->language->saveLanguages($request);
        Session::flash('message', trans('lang.save_language'));
        return Redirect::back();
    }

   
    public function edit($id)
    {
        if (!empty($id)) {
            $langs = $this->language::find($id);
            if (!empty($langs)) {
                return View::make(
                    'job.back-end.admin.languages.edit', compact('id', 'langs')
                );
                Session::flash('message', trans('lang.lang_updated'));
                return Redirect::to('Job/admin/languages');
            }
        }
    }

   
    public function update(Request $request, $id)
    {
        $server_verification = JobHelper::worketicIsDemoSite();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $this->validate(
            $request, [
                'language_title' => 'required',
            ]
        );
        $this->language->updateLanguage($request, $id);
        Session::flash('message', trans('lang.lang_updated'));
        return Redirect::to('admin/languages');
    }

    
    public function destroy(Request $request)
    {
        $server = JobHelper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $json['type'] = 'error';
            $json['message'] = $server->getData()->message;
            return $json;
        }
        $json = array();
        $id = $request['id'];
        if (!empty($id)) {
            $this->language::where('id', $id)->delete();
            $json['type'] = 'success';
            $json['message'] = trans('lang.lang_deleted');
            return $json;
        }
    }

   
    public function deleteSelected(Request $request)
    {
        $server = JobHelper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $json['type'] = 'error';
            $json['message'] = $server->getData()->message;
            return $json;
        }
        $json = array();
        $checked = $request['ids'];
        foreach ($checked as $id) {
            $this->language::where("id", $id)->delete();
        }
        if (!empty($checked)) {
            $json['type'] = 'success';
            $json['message'] = trans('lang.lang_deleted');
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }
}
