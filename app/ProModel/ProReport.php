<?php
namespace App\ProModel;

use Illuminate\Database\Eloquent\Model;
use App\ProModel\ProJob;
use App\ProModel\ProProposal;

/**
 * Class Report
 *
 */
class ProReport extends Model
{
    /**
     * Get all of the owning commentable models.
     *
     * @return polymorphic relation
     */
    public function reportable()
    {
        return $this->morphTo();
    }

    /**
     * Submit Report
     *
     * @param mixed $request req->attr
     *
     * @return request\response
     */
    public static function submitReport($request)
    {
        if (!empty($request['id'])) {
            $model = $request['model']::find($request['id']);
            if ($request['report_type'] == 'proposal_cancel') {
                $model->status = 'posted';
                $model->save();
                $proposal = ProProposal::find($request['proposal_id']);
                $proposal->status = 'Cancelled';
                $proposal->save();

            }
            $report = new ProReport;
            $report->reason = filter_var($request['reason'], FILTER_SANITIZE_STRING);
            $report->description = filter_var($request['description'], FILTER_SANITIZE_STRING);
            $model->reports()->save($report);
            return 'success';
        }
    }
}
