<?php

namespace InetStudio\CommentsPackage\Comments\Services\Back;

use Exception;
use Throwable;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use InetStudio\CommentsPackage\Comments\Contracts\Models\CommentModelContract;
use InetStudio\CommentsPackage\Comments\Contracts\Services\Back\DataTableServiceContract;

/**
 * Class DataTableService.
 */
class DataTableService extends DataTable implements DataTableServiceContract
{
    /**
     * @var CommentModelContract
     */
    protected $model;

    /**
     * DataTableService constructor.
     *
     * @param  CommentModelContract  $model
     */
    public function __construct(CommentModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * Получение данных таблицы.
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function ajax(): JsonResponse
    {
        $transformer = app()->make('InetStudio\CommentsPackage\Comments\Contracts\Transformers\Back\Resource\IndexTransformerContract');

        return DataTables::of($this->query())
            ->setTransformer($transformer)
            ->rawColumns(['checkbox', 'read', 'active', 'material', 'actions'])
            ->make();
    }

    /**
     * Получаем запрос для получения данных.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = $this->model->buildQuery([
            'columns' => ['created_at'],
        ])->with(['commentable']);

        return $query;
    }

    /**
     * Генерация таблицы.
     *
     * @return Builder
     *
     * @throws Throwable
     */
    public function html(): Builder
    {
        /** @var Builder $table */
        $table = app('datatables.html');

        return $table
            ->columns($this->getColumns())
            ->ajax($this->getAjaxOptions())
            ->parameters($this->getParameters());
    }

    /**
     * Получаем колонки.
     *
     * @return array
     *
     * @throws Throwable
     */
    protected function getColumns(): array
    {
        return [
            [
                'data' => 'checkbox',
                'name' => 'checkbox',
                'title' => view('admin.module.comments::back.partials.datatables.checkbox')->render(),
                'orderable' => false,
                'searchable' => false,
            ],
            ['data' => 'read', 'name' => 'is_read', 'title' => 'Прочитано', 'searchable' => false],
            ['data' => 'active', 'name' => 'is_active', 'title' => 'Активность', 'searchable' => false],
            ['data' => 'name', 'name' => 'name', 'title' => 'Имя'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'message', 'name' => 'message', 'title' => 'Сообщение'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Дата создания'],
            [
                'data' => 'material',
                'name' => 'material',
                'title' => 'Материал',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'data' => 'actions',
                'name' => 'actions',
                'title' => 'Действия',
                'orderable' => false,
                'searchable' => false,
            ],
        ];
    }

    /**
     * Свойства ajax datatables.
     *
     * @return array
     */
    protected function getAjaxOptions(): array
    {
        return [
            'url' => route('back.comments.data.index'),
            'type' => 'POST',
        ];
    }

    /**
     * Свойства datatables.
     *
     * @return array
     */
    protected function getParameters(): array
    {
        $translation = trans('admin::datatables');

        return [
            'order' => [
                6,
                'desc',
            ],
            'paging' => true,
            'pagingType' => 'full_numbers',
            'searching' => true,
            'info' => false,
            'searchDelay' => 350,
            'language' => $translation,
        ];
    }
}
