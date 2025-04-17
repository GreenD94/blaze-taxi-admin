<?php

namespace App\DataTables;

use App\Models\Bonus;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

use App\Traits\DataTableTrait;

class BonusDataTable extends DataTable
{
    use DataTableTrait;
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            
            ->editColumn('status', function($query) {
                $status = 'warning';
                switch ($query->status) {
                    case 'active':
                        $status = 'primary';
                        break;
                    case 'inactive':
                        $status = 'danger';
                        break;
                    case 'banned':
                        $status = 'dark';
                        break;
                }
                return '<span class="text-capitalize badge bg-'.$status.'">'.$query->status.'</span>';
            })
            ->editColumn('starts_at', function($query) {

                if($query->start_date_type == 'verification_date') {
                    return __('message.verification_date');
                } else if ( $query->start_date_type == 'fixed') {
                    return date('Y/m/d',strtotime($query->starts_at));
                }

            })->editColumn('ends_at', function($query) {

                if($query->end_date_type == 'days_to_expiration') {
                    return $query->days_to_expiration . ' ' . __('message.days_to_expiration');
                } else if ( $query->end_date_type == 'fixed') {
                    return date('Y/m/d',strtotime($query->ends_at));
                }

            })
            ->editColumn('created_at', function($query) {
                return date('Y/m/d',strtotime($query->created_at));
            })
            ->addIndexColumn()
            // ->addColumn('action', 'driver.action')
            ->addColumn('action', function($data){
                $id = $data->id;
                return view('bonus.action',compact('data','id'))->render();
            })
            ->rawColumns(['action','status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = Bonus::query();

        if($this->status != null){
            $model = $model->where('status', $this->status);
        } else {
            // $model = $model->where('status','active');
        }

        return $this->applyScopes($model);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')
                ->searchable(false)
                ->title(__('message.srno'))
                ->orderable(false)
                ->width(60),
            Column::make('name')->title( __('message.name') ),
            Column::make('amount')->title( __('message.amount') ),
            Column::make('rides_qty')->title( __('message.rides_qty') ),
            Column::make('starts_at')->title( __('message.starts_at') ),
            Column::make('ends_at')->title( __('message.ends_at') ),
            Column::make('status')->title( __('message.status') ),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'bonuses_' . date('YmdHis');
    }
}
