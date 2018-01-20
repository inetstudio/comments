<?php

namespace InetStudio\Comments\Http\Controllers\Back;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use InetStudio\Comments\Models\CommentModel;
use InetStudio\Comments\Events\UpdateCommentsEvent;
use InetStudio\Comments\Transformers\CommentTransformer;
use InetStudio\Comments\Http\Requests\Back\SaveCommentRequest;
use InetStudio\AdminPanel\Http\Controllers\Back\Traits\DatatablesTrait;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(): View
    {
        $table = $this->generateTable('comments', 'index');

        return view('admin.module.comments::back.pages.index', compact('table'));
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
     * Добавление ответа.
     *
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function answer($id): View
    {
        if (! is_null($id) && $id > 0 && $item = CommentModel::find($id)) {
            $item->update([
                'is_read' => true,
            ]);

            return view('admin.module.comments::back.pages.answer', [
                'item' => $item,
            ]);
        } else {
            abort(404);
        }
    }

    /**
     * Создание комментария.
     *
     * @param SaveCommentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SaveCommentRequest $request): RedirectResponse
    {
        return $this->save($request);
    }

    /**
     * Редактирование комментария.
     *
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id = null): View
    {
        if (! is_null($id) && $id > 0 && $item = CommentModel::find($id)) {
            $item->update([
                'is_read' => true,
            ]);
            
            return view('admin.module.comments::back.pages.form', [
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
    public function update(SaveCommentRequest $request, $id = null): RedirectResponse
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
    private function save(SaveCommentRequest $request, $id = null): RedirectResponse
    {
        if (! is_null($id) && $id > 0 && $item = CommentModel::find($id)) {
            $action = 'отредактирован';
        } else {
            $parentId = $request->get('parent_comment_id');
            if (! is_null($parentId) && $parentId > 0 && $parentItem = CommentModel::find($parentId)) {
                $action = 'создан';
                $item = new CommentModel();
            } else {
                abort(404);
            }
        }

        if ($request->filled('parent_comment_id')) {
            $user = \Auth::user();

            $item->is_read = true;
            $item->is_active = true;
            $item->user_id = $user->id;
            $item->name = $user->name;
            $item->email = $user->email;
            $item->message = strip_tags($request->input('message.text'));
            $item->commentable_id = $parentItem->commentable_id;
            $item->commentable_type = $parentItem->commentable_type;
        } else {
            $item->is_active = strip_tags($request->get('is_active'));
        }

        if ($parentItem) {
            $item->appendToNode($parentItem)->save();
        } else {
            $item->save();
        }

        event(new UpdateCommentsEvent($item));

        Session::flash('success', 'Комментарий успешно '.$action);

        return redirect()->to(route('back.comments.edit', $item->fresh()->id));
    }

    /**
     * Удаление комментария.
     *
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id = null): JsonResponse
    {
        return response()->json([
            'success' => $this->destroyComment($id),
        ]);
    }

    /**
     * Проставляем активность комментарию.
     *
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeActivity($id = null): JsonResponse
    {
        return response()->json([
            'success' => $this->activityComment($id),
        ]);
    }

    /**
     * Массовое изменение активности.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function groupActivity(Request $request): JsonResponse
    {
        if ($request->filled('comments')) {
            foreach ($request->get('comments') as $commentId) {
                $this->activityComment($commentId);
            }
        }

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Массовая пометка "прочитано".
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function groupRead(Request $request): JsonResponse
    {
        if ($request->filled('comments')) {
            foreach ($request->get('comments') as $commentId) {
                $this->readComment($commentId);
            }
        }

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Массовое удаление комментариев.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function groupDestroy(Request $request): JsonResponse
    {
        if ($request->filled('comments')) {
            foreach ($request->get('comments') as $commentId) {
                $this->destroyComment($commentId);
            }
        }

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Изменяем активность комментария.
     *
     * @param $id
     * @return bool
     */
    private function activityComment($id): bool
    {
        if (! is_null($id) && $id > 0 && $item = CommentModel::find($id)) {
            $item->update([
                'is_active' => ! $item->is_active,
            ]);

            event(new UpdateCommentsEvent($item));

            return true;
        } else {
            return false;
        }
    }

    /**
     * Меняем признак просмотра.
     *
     * @param $id
     * @return bool
     */
    private function readComment($id): bool
    {
        if (! is_null($id) && $id > 0 && $item = CommentModel::find($id)) {
            $item->update([
                'is_read' => ! $item->is_read,
            ]);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Удаление комментария.
     *
     * @param $id
     * @return bool
     */
    private function destroyComment($id): bool
    {
        if (! is_null($id) && $id > 0 && $item = CommentModel::find($id)) {
            $item->delete();

            return true;
        } else {
            return false;
        }
    }
}
