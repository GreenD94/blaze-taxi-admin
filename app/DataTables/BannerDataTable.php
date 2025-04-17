<?php

namespace App\DataTables;

use App\Models\Banner;
use App\Models\Bonus;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

use App\Traits\DataTableTrait;

class BannerDataTable extends DataTable
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
            ->editColumn('image', function ($query) {
                return '<img src="' .getSingleMedia($query,'banner'). '" width="60"  id="app_image_preview" alt="app_image" class="image app_image app_image_preview">';
            })
            ->editColumn('user_type', function ($query) {
                $user_type = 'Driver';
                switch ($query->user_type) {
                    case 'drivers':
                        $user_type = __('message.driver');
                        break;
                    case 'riders':
                        $user_type = __('message.rider');
                        break;

                    default:
                        # code...
                        break;
                }
                return $user_type;
            })
            ->editColumn('status', function ($query) {
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
                return '<span class="text-capitalize badge bg-' . $status . '">' . $query->status . '</span>';
            })

            ->editColumn('created_at', function ($query) {
                return date('Y/m/d', strtotime($query->created_at));
            })
            ->addIndexColumn()
            // ->addColumn('action', 'driver.action')
            ->addColumn('action', function ($data) {
                $id = $data->id;
                return view('banner.action', compact('data', 'id'))->render();
            })
            ->rawColumns(['action', 'status', 'image']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = Banner::query();

        if ($this->status != null) {
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
            Column::make('name')->title(__('message.name')),
            Column::make('image')->title(__('message.banner')),
            Column::make('user_type')->title(__('message.user_type')),
            Column::make('status')->title(__('message.status')),
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
        return 'banners_' . date('YmdHis');
    }
}
