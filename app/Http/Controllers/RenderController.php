<?php

namespace App\Http\Controllers;

use App\Services\PageService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RenderController extends Controller
{
    public function __construct(private readonly PageService $pageService)
    {
    }

    public function renderLanding(Request $request): Response
    {
        return Inertia::render('Landing', $this->pageService->landing());
    }

    public function renderLogin(Request $request): Response
    {
        return Inertia::render('Login');
    }

    public function renderRegister(Request $request): Response
    {
        return Inertia::render('Register');
    }

    public function renderConnect(Request $request): Response
    {
        return Inertia::render('Connect');
    }

    public function renderDashboard(Request $request): Response
    {
        return Inertia::render('Dashboard', $this->pageService->dashboard($request->user()));
    }

    public function renderMyReports(Request $request): Response
    {
        return Inertia::render('MyReports', $this->pageService->myReports($request->user()));
    }

    public function renderPublicList(Request $request): Response
    {
        return Inertia::render('PublicList', $this->pageService->publicList());
    }

    public function renderEarnings(Request $request): Response
    {
        return Inertia::render('Earnings', $this->pageService->earnings($request->user()));
    }
}
