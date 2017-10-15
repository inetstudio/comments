<?php

namespace InetStudio\Comments\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use InetStudio\Comments\Models\CommentModel;
use InetStudio\AdminPanel\Traits\DatatablesTrait;
use InetStudio\Comments\Requests\SaveCommentRequest;
use InetStudio\Comments\Transformers\CommentTransformer;

/**
 * Контроллер для управления комментариями.
 *
 * Class ContestByTagStatusesController
 */
class CommentsController extends Controller
{
    use DatatablesTrait;

    /**
     * Список комментариев.
     *
     * @param DataTables $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(DataTables $dataTable)
    {
        $table = $this->generateTable($dataTable, 'comments', 'index');

        return view('admin.module.comments::pages.index', compact('table'));
    }

    /**
     * Datatables serverside.
     *
     * @return mixed
     */
    public function data()
    {
        $items = CommentModel::query();

        return DataTables::of($items)
            ->setTransformer(new CommentTransformer)
            ->rawColumns(['actions'])
            ->make();
    }
    
    /**
     * Редактирование комментария.
     *
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id = null)
    {
        if (! is_null($id) && $id > 0 && $item = CommentModel::find($id)) {
            $item->update([
                'is_read' => true,
            ]);
            
            return view('admin.module.comments::pages.form', [
                'item' => $item,
            ]);
        } else {
            abort(404);
        }
    }

    /**
     * Обновление комментария.
     *
     * @param SaveCommentRequest $request
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SaveCommentRequest $request, $id = null)
    {
        return $this->save($request, $id);
    }

    /**
     * Сохранение комментария.
     *
     * @param SaveCommentRequest $request
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    private function save($request, $id = null)
    {
        if (! is_null($id) && $id > 0 && $item = CommentModel::find($id)) {
            $action = 'отредактирован';
        } else {
            abort(404);
        }

        $item->is_active = strip_tags($request->get('is_active'));
        $item->save();

        \Event::fire('inetstudio.comments.cache.clear', md5($item->commentable_type.$item->commentable_id));

        Session::flash('success', 'Комментарий успешно '.$action);

        return redirect()->to(route('back.comments.edit', $item->fresh()->id));
    }

    /**
     * Удаление комментария.
     *
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id = null)
    {
        if (! is_null($id) && $id > 0 && $item = CommentModel::find($id)) {
            $item->delete();

            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    /**
     * Проставляем активность комментарию.
     *
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeActivity(Request $request, $id = null)
    {
        if (! is_null($id) && $id > 0 && $item = CommentModel::find($id)) {
            $item->update([
                'is_active' => $request->get('val'),
            ]);

            \Event::fire('inetstudio.comments.cache.clear', md5($item->commentable_type.$item->commentable_id));

            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }
}
