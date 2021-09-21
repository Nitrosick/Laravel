<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\News;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\NewsCreateRequest;
use App\Http\Requests\NewsUpdateRequest;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $newsList = News::with('category')
			->paginate(10);

        return view('admin.news.index', [
            'newsList' => $newsList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.news.create', [
			'categories' => $categories
		]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\NewsCreateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(NewsCreateRequest $request)
    {
        $news = News::create($request->validated());

		if($news) {
			return redirect()
				->route('admin.news.index')
                ->with('success', __('messages.admin.news.create.success'));
		}

		return back()
            ->with('error', __('messages.admin.news.create.fail'))
			->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param News $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param News $news
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        $categories =  Category::all();

        return view('admin.news.edit', [
			'news' => $news,
			'categories' => $categories
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param News $news
     * @param  \Illuminate\Http\NewsUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(NewsUpdateRequest $request, News $news)
    {
        $news = $news->fill($request->validated())->save();

		if($news) {
			return redirect()
				->route('admin.news.index')
                ->with('success', __('messages.admin.news.update.success'));
		}

		return back()
            ->with('error', __('messages.admin.news.update.fail'))
			->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param News $news
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, News $news)
    {
        if($request->ajax()) {
            try {
                $news->delete();
                return response()->json(['message' => 'success']);

            } catch (\Exception $e) {
                Log::error("Error delete news" . PHP_EOL, [$e]);
                return response()->json(['message' => 'error'], 400);
            }
        }
    }
}
