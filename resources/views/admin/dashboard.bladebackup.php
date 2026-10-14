@extends('admin.layouts.app')

@section('title', 'Admin Dashboard - College ERP')

@section('content')

<style>

    /* =========================================================
       CLEAR / HD TYPOGRAPHY
    ========================================================= */

    html {
        -webkit-text-size-adjust: 100%;
        text-rendering: optimizeLegibility;
    }

    .erp-dashboard,
    .erp-dashboard * {
        font-family:
            "Segoe UI",
            Inter,
            Roboto,
            Arial,
            Helvetica,
            sans-serif;
    }

    .erp-dashboard {
        font-size: 14px;
        font-weight: 500;
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    * {
        box-sizing: border-box;
    }

    :root {
        --erp-primary: #6852e8;
        --erp-primary-dark: #4f3cc5;
        --erp-primary-soft: #f3f0ff;

        --erp-text: #202637;
        --erp-text-2: #374151;
        --erp-muted: #7d8798;

        --erp-bg: #f4f6fa;
        --erp-card: #ffffff;
        --erp-border: #e7eaf0;

        --erp-shadow:
            0 8px 26px rgba(31, 41, 55, 0.07);

        --erp-shadow-hover:
            0 18px 40px rgba(31, 41, 55, 0.13);
    }

    /* =========================================================
       PAGE
    ========================================================= */

    .erp-dashboard {
        width: 100%;
        min-height: calc(100vh - 70px);

        padding: 22px;

        background:
            radial-gradient(
                circle at 95% 0%,
                rgba(104, 82, 232, 0.08),
                transparent 24%
            ),
            linear-gradient(
                180deg,
                #f8f9fc 0%,
                #f3f5f9 100%
            );
    }

    .erp-dashboard-inner {
        width: 100%;
        max-width: 1800px;
        margin: 0 auto;
    }


    /* =========================================================
       HEADER
    ========================================================= */

    .erp-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 18px;

        margin-bottom: 20px;
    }

    .erp-page-title h1 {
        margin: 0;

        color: var(--erp-text);

        font-size: 26px;
        line-height: 1.2;
        font-weight: 850;

        letter-spacing: -0.55px;
    }

    .erp-page-title p {
        margin: 6px 0 0;

        color: var(--erp-muted);

        font-size: 14px;
        font-weight: 500;
    }

    .erp-session {
        display: inline-flex;
        align-items: center;
        gap: 9px;

        padding: 10px 14px;

        background: #ffffff;

        border: 1px solid #e2def7;

        border-radius: 12px;

        color: var(--erp-primary-dark);

        font-size: 14px;
        font-weight: 800;

        box-shadow: 0 5px 16px rgba(31, 41, 55, 0.05);
    }

    .erp-session-dot {
        width: 8px;
        height: 8px;

        border-radius: 50%;

        background: #11a879;

        box-shadow: 0 0 0 4px rgba(17, 168, 121, 0.12);
    }


    /* =========================================================
       TOP METRIC CARDS
    ========================================================= */

    .erp-metrics {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 14px;

        margin-bottom: 20px;
    }

    .erp-metric {
        position: relative;

        min-height: 118px;

        padding: 17px;

        border-radius: 17px;

        overflow: hidden;

        color: #ffffff;

        box-shadow: var(--erp-shadow);

        transition:
            transform .22s ease,
            box-shadow .22s ease;
    }

    .erp-metric:hover {
        transform: translateY(-3px);
        box-shadow: var(--erp-shadow-hover);
    }

    .erp-metric::before {
        content: "";

        position: absolute;

        width: 135px;
        height: 135px;

        top: -72px;
        right: -55px;

        border-radius: 50%;

        background: rgba(255,255,255,.12);
    }

    .erp-metric::after {
        content: "";

        position: absolute;

        width: 95px;
        height: 95px;

        left: -45px;
        bottom: -55px;

        border-radius: 50%;

        background: rgba(255,255,255,.07);
    }

    .metric-purple {
        background: linear-gradient(135deg, #7c62ee, #5b42d0);
    }

    .metric-orange {
        background: linear-gradient(135deg, #f7bc5c, #e39116);
    }

    .metric-green {
        background: linear-gradient(135deg, #25c697, #0a9f71);
    }

    .metric-blue {
        background: linear-gradient(135deg, #5195f0, #3476d8);
    }

    .metric-indigo {
        background: linear-gradient(135deg, #8180f7, #5e5bd6);
    }

    .metric-red {
        background: linear-gradient(135deg, #fc7381, #dd4c60);
    }

    .metric-cyan {
        background: linear-gradient(135deg, #32b9ca, #0e8999);
    }

    .erp-metric-content {
        position: relative;
        z-index: 2;
    }

    .erp-metric-icon {
        width: 42px;
        height: 42px;

        border-radius: 12px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: rgba(255,255,255,.16);

        border: 1px solid rgba(255,255,255,.16);

        font-size: 19px;

        backdrop-filter: blur(7px);
    }

    .erp-metric-title {
        margin-top: 12px;

        font-size: 14px;

        font-weight: 700;

        opacity: .9;
    }

    .erp-metric-number {
        margin-top: 3px;

        font-size: 25px;

        line-height: 1;

        font-weight: 900;
    }


    /* =========================================================
       PROGRAMME PANEL
    ========================================================= */

    .erp-panel {
        background: var(--erp-card);

        border: 1px solid var(--erp-border);

        border-radius: 20px;

        box-shadow: var(--erp-shadow);

        overflow: hidden;

        margin-bottom: 20px;
    }

    .erp-panel-header {
        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 18px;

        padding: 18px 21px;

        border-bottom: 1px solid #edf0f4;

        background:
            linear-gradient(
                180deg,
                #ffffff 0%,
                #fcfcfe 100%
            );
    }

    .erp-panel-title h2 {
        margin: 0;

        font-size: 18px;
        font-weight: 850;

        color: var(--erp-text);
    }

    .erp-panel-title p {
        margin: 5px 0 0;

        font-size: 14px;

        color: var(--erp-muted);
    }


    .erp-panel-counts {
        display: flex;

        align-items: center;

        gap: 8px;

        flex-wrap: wrap;

        justify-content: flex-end;
    }

    .erp-count-pill {
        display: inline-flex;

        align-items: center;

        gap: 6px;

        padding: 8px 10px;

        border-radius: 10px;

        border: 1px solid #e8e4fb;

        background: #f6f4ff;

        color: #5a43cd;

        font-size: 14px;

        font-weight: 800;

        white-space: nowrap;
    }


    /* =========================================================
       GROUP LEGEND
    ========================================================= */

    .erp-group-strip {
        padding:
            16px
            20px
            4px;

        display: flex;

        align-items: center;

        gap: 8px;

        flex-wrap: wrap;
    }

    .erp-group-strip-label {
        margin-right: 3px;

        color: #848c99;

        font-size: 14px;

        font-weight: 800;

        text-transform: uppercase;

        letter-spacing: .45px;
    }

    .erp-group-tag {
        display: inline-flex;

        align-items: center;

        padding: 6px 10px;

        border-radius: 999px;

        background: #fafbfe;

        border: 1px solid #e5e8ef;

        color: #656e7e;

        font-size: 14px;

        font-weight: 800;
    }


    /* =========================================================
       DEPARTMENT GRID
    ========================================================= */

    .erp-department-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 15px;

        padding: 16px 20px 21px;
    }


    .erp-department-card {
        position: relative;
        min-width: 0;
        min-height: 218px;
        border-radius: 17px;
        border: 1px solid var(--dept-border, #e7e9f0);
        background:
            radial-gradient(
                circle at 100% 0%,
                var(--dept-glow, rgba(104, 82, 232, 0.075)),
                transparent 35%
            ),
            var(--dept-bg, #ffffff);
        box-shadow: 0 5px 18px rgba(31, 41, 55, 0.055);
        overflow: hidden;
        transition:
            transform .23s ease,
            border-color .23s ease,
            box-shadow .23s ease;
    }

    .erp-department-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background:
            linear-gradient(
                90deg,
                var(--dept-accent, #6852e8),
                var(--dept-accent-2, #8a74f2)
            );
    }

    .erp-department-card.theme-cs {
        --dept-accent: #5542c7;
        --dept-accent-2: #8069ec;
        --dept-bg: #fbfaff;
        --dept-glow: rgba(104,82,232,.11);
        --dept-border: #e4dff8;
        --dept-border-hover: #cec4ee;
    }

    .erp-department-card.theme-commerce {
        --dept-accent: #087554;
        --dept-accent-2: #22b988;
        --dept-bg: #fbfefc;
        --dept-glow: rgba(25,169,125,.09);
        --dept-border: #dceee6;
        --dept-border-hover: #bfdfd1;
    }

    .erp-department-card.theme-arts {
        --dept-accent: #bf5b18;
        --dept-accent-2: #ef9a56;
        --dept-bg: #fffdfb;
        --dept-glow: rgba(235,143,72,.09);
        --dept-border: #f0e1d7;
        --dept-border-hover: #e4cbbb;
    }

    .erp-department-card.theme-science {
        --dept-accent: #2463b2;
        --dept-accent-2: #4d96ee;
        --dept-bg: #fbfdff;
        --dept-glow: rgba(61,139,228,.09);
        --dept-border: #dae7f5;
        --dept-border-hover: #c1d7ec;
    }

    .erp-department-card.theme-pg {
        --dept-accent: #7629ad;
        --dept-accent-2: #bb63e6;
        --dept-bg: #fefbff;
        --dept-glow: rgba(175,85,222,.09);
        --dept-border: #eadcf1;
        --dept-border-hover: #d8c0e7;
    }

    .erp-department-card.theme-education {
        --dept-accent: #ae6700;
        --dept-accent-2: #ebb23e;
        --dept-bg: #fffdf8;
        --dept-glow: rgba(230,169,52,.09);
        --dept-border: #efe5d2;
        --dept-border-hover: #e2d1b3;
    }

    .erp-department-card.theme-pharmacy {
        --dept-accent: #b52f4c;
        --dept-accent-2: #ee6480;
        --dept-bg: #fffafb;
        --dept-glow: rgba(227,83,116,.09);
        --dept-border: #f0dfe4;
        --dept-border-hover: #e7c8d1;
    }

    .erp-department-card.theme-nursing {
        --dept-accent: #0b7581;
        --dept-accent-2: #2db8c5;
        --dept-bg: #faffff;
        --dept-glow: rgba(37,171,185,.09);
        --dept-border: #dceff1;
        --dept-border-hover: #c2e0e3;
    }

    .erp-department-card.theme-default {
        --dept-accent: #515b6b;
        --dept-accent-2: #7b8595;
        --dept-bg: #fcfcfd;
        --dept-glow: rgba(108,119,134,.08);
        --dept-border: #e4e7ec;
        --dept-border-hover: #d4d9e1;
    }

    .erp-department-card:hover {
        transform: translateY(-4px);
        border-color: var(--dept-border-hover, #dcd6fb);
        box-shadow: 0 17px 34px rgba(31, 41, 55, 0.11);
    }


    .erp-department-card::after {
        content: "";

        position: absolute;

        width: 125px;
        height: 125px;

        right: -58px;
        bottom: -63px;

        border-radius: 50%;

        border: 1px solid rgba(104, 82, 232, 0.06);
    }


    .erp-department-inner {
        position: relative;

        z-index: 2;

        padding: 16px;
    }


    /* =========================================================
       DEPARTMENT CARD TOP
    ========================================================= */

    .erp-department-top {
        display: flex;

        align-items: flex-start;

        justify-content: space-between;

        gap: 12px;
    }


    .erp-department-brand {
        min-width: 0;

        display: flex;

        align-items: center;

        gap: 10px;
    }


    .erp-department-logo {
        width: 50px;
        height: 50px;

        flex: 0 0 50px;

        display: flex;

        align-items: center;

        justify-content: center;

        position: relative;

        overflow: hidden;

        border-radius: 14px;

        color: #ffffff;

        font-size: 14px;

        font-weight: 900;

        letter-spacing: .45px;

        box-shadow:
            0 8px 18px rgba(55, 44, 130, .15);
    }

    .erp-department-logo::before {
        content: "";

        position: absolute;

        inset: 0;

        background:
            linear-gradient(
                135deg,
                rgba(255,255,255,.26),
                transparent 45%
            );
    }

    .erp-department-logo::after {
        content: "";

        position: absolute;

        width: 70px;
        height: 16px;

        right: -24px;
        bottom: 7px;

        transform: rotate(-35deg);

        background:
            rgba(255,255,255,.10);
    }

    .erp-department-logo span {
        position: relative;

        z-index: 3;
    }


    .dept-cs {
        background: linear-gradient(135deg, #7657ed, #4e36c2);
    }

    .dept-commerce {
        background: linear-gradient(135deg, #20bd8d, #087b59);
    }

    .dept-arts {
        background: linear-gradient(135deg, #f09a55, #c5571a);
    }

    .dept-science {
        background: linear-gradient(135deg, #4a94ee, #2565b9);
    }

    .dept-pg {
        background: linear-gradient(135deg, #be65e9, #7f2cb3);
    }

    .dept-education {
        background: linear-gradient(135deg, #efb33f, #bf6e03);
    }

    .dept-pharmacy {
        background: linear-gradient(135deg, #ef647f, #bb3150);
    }

    .dept-nursing {
        background: linear-gradient(135deg, #2db9c6, #0c7f8b);
    }

    .dept-default {
        background: linear-gradient(135deg, #7b8494, #4e5766);
    }


    .erp-department-name {
        min-width: 0;
    }

    .erp-department-name h3 {
        margin: 0;

        color: #252b3b;

        font-size: 14px;

        line-height: 1.25;

        font-weight: 850;
    }

    .erp-department-group {
        margin-top: 4px;

        color: #8e96a5;

        font-size: 14px;

        line-height: 1.25;

        font-weight: 700;

        white-space: nowrap;

        overflow: hidden;

        text-overflow: ellipsis;
    }


    .erp-student-total {
        min-width: 55px;

        flex: 0 0 auto;

        text-align: center;

        padding: 8px 7px;

        border-radius: 11px;

        background:
            linear-gradient(
                180deg,
                #f7f4ff,
                #f2efff
            );

        border: 1px solid #e8e1ff;

        color: #5e47cb;
    }

    .erp-student-total strong {
        display: block;

        font-size: 17px;

        line-height: 1;

        font-weight: 900;
    }

    .erp-student-total span {
        display: block;

        margin-top: 3px;

        font-size: 14px;

        font-weight: 900;

        text-transform: uppercase;

        letter-spacing: .35px;
    }


    /* =========================================================
       DEPARTMENT CARD MIDDLE
    ========================================================= */

    .erp-department-stats {
        display: grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap: 7px;

        margin-top: 15px;
    }

    .erp-department-stat {
        min-width: 0;

        padding: 9px 7px;

        text-align: center;

        border-radius: 11px;

        border: 1px solid #eceef3;

        background:
            linear-gradient(
                180deg,
                #fbfcfd,
                #f7f8fa
            );
    }

    .erp-department-stat-label {
        font-size: 14px;

        color: #9299a7;

        text-transform: uppercase;

        letter-spacing: .35px;

        font-weight: 850;
    }

    .erp-department-stat-value {
        margin-top: 4px;
        font-size: 15px;
        line-height: 1.05;
        color: #303848;
        font-weight: 900;
    }

    .erp-department-session {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 21px;
        padding: 3px 7px;
        border-radius: 6px;
        background: #ffffff;
        border: 1px solid #e1e5eb;
        color: #586272;
        font-size: 14px;
        font-weight: 900;
    }


    /* =========================================================
       PROGRAMME NAME PREVIEW
    ========================================================= */

    .erp-programme-preview {
        margin-top: 12px;
        padding: 10px 11px;
        border-radius: 12px;
        background:
            linear-gradient(
                180deg,
                rgba(255,255,255,.96),
                rgba(248,249,252,.98)
            );
        border: 1px solid #e3e7ed;
    }

    .erp-programme-preview-title {
        margin-bottom: 7px;
        color: #697384;
        font-size: 14px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .55px;
    }

    .erp-programme-preview-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 6px;
    }

    .erp-programme-chip {
        min-width: 0;
        min-height: 34px;
        padding: 6px 8px;
        border-radius: 8px;
        background: #ffffff;
        border: 1px solid #dfe3e9;
        color: #273041;
        display: flex;
        align-items: center;
        gap: 7px;
        box-shadow: 0 2px 6px rgba(31,41,55,.035);
    }

    .erp-course-code {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        min-height: 21px;
        padding: 3px 6px;
        border-radius: 6px;
        background: var(--dept-bg, #f3f0ff);
        border: 1px solid var(--dept-border, #e6e0f8);
        color: var(--dept-accent, #5542c7);
        font-size: 14px;
        line-height: 1;
        font-weight: 950;
        letter-spacing: .25px;
    }

    .erp-course-name {
        min-width: 0;
        color: #394354;
        font-size: 14px;
        line-height: 1.2;
        font-weight: 750;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .erp-programme-more {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 34px;
        padding: 6px 9px;
        border-radius: 8px;
        background: #f5f2ff;
        border: 1px solid #e2dcf8;
        color: #5a43cb;
        font-size: 14px;
        font-weight: 900;
    }


    /* =========================================================
       VIEW DETAILS BUTTON
    ========================================================= */

    .erp-detail-button {
        width: 100%;

        margin-top: 12px;

        padding: 10px 12px;

        border: 0;

        border-radius: 10px;

        background:
            linear-gradient(
                135deg,
                #f2efff,
                #eae5ff
            );

        color: #5840d0;

        font-size: 14px;

        font-weight: 900;

        cursor: pointer;

        display: flex;

        align-items: center;

        justify-content: center;

        gap: 8px;

        transition:
            background .2s ease,
            box-shadow .2s ease;
    }

    .erp-detail-button:hover {
        background:
            linear-gradient(
                135deg,
                #e9e3ff,
                #ded6ff
            );
    }

    .erp-detail-button.active {
        background:
            linear-gradient(
                135deg,
                #6d50e8,
                #5638ca
            );

        color: #ffffff;

        box-shadow:
            0 7px 17px rgba(84, 57, 202, .22);
    }

    .erp-detail-arrow {
        font-size: 14px;

        transition:
            transform .2s ease;
    }

    .erp-detail-button.active .erp-detail-arrow {
        transform: rotate(180deg);
    }


    /* =========================================================
       SHARED DEPARTMENT DETAIL
    ========================================================= */

    .erp-detail-panel {
        display: none;

        margin:
            0 20px 20px;

        border-radius: 17px;

        border: 1px solid #e3e6ed;

        background:
            radial-gradient(
                circle at top right,
                rgba(104,82,232,.065),
                transparent 28%
            ),
            #ffffff;

        box-shadow:
            0 11px 30px rgba(31, 41, 55, 0.075);

        overflow: hidden;

        animation:
            erpDetailIn .22s ease;
    }

    .erp-detail-panel.open {
        display: block;
    }

    @keyframes erpDetailIn {

        from {
            opacity: 0;
            transform: translateY(-5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }


    .erp-detail-header {
        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 15px;

        padding: 16px 18px;

        border-bottom: 1px solid #eceef3;

        background:
            linear-gradient(
                180deg,
                #ffffff,
                #fbfbfd
            );
    }

    .erp-detail-header-left {
        display: flex;

        align-items: center;

        gap: 10px;
    }

    .erp-detail-heading-dot {
        width: 9px;
        height: 9px;

        border-radius: 3px;

        background:
            linear-gradient(
                135deg,
                #8165ff,
                #5137be
            );

        box-shadow:
            0 3px 9px rgba(104,82,232,.23);
    }

    .erp-detail-header-left h3 {
        margin: 0;

        font-size: 15px;

        font-weight: 850;

        color: #2b3141;
    }

    .erp-detail-close {
        width: 31px;
        height: 31px;

        border-radius: 9px;

        border: 1px solid #e2e5eb;

        background: #ffffff;

        color: #6f7785;

        font-size: 17px;

        font-weight: 800;

        cursor: pointer;
    }

    .erp-detail-close:hover {
        background: #f6f7fa;
    }


    .erp-detail-body {
        padding: 15px;
    }


    /* =========================================================
       PROGRAMME DETAILS GRID
    ========================================================= */

    .erp-programme-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 13px;
    }


    .erp-programme-card {
        min-width: 0;

        padding: 14px;

        border-radius: 15px;

        border: 1px solid #e8eaf0;

        background:
            linear-gradient(
                180deg,
                #ffffff,
                #fbfbfd
            );

        box-shadow:
            0 5px 16px rgba(31,41,55,.04);
    }


    .erp-programme-head {
        display: flex;

        justify-content: space-between;

        align-items: flex-start;

        gap: 12px;
    }


    .erp-programme-title {
        margin: 0;

        font-size: 14px;

        line-height: 1.3;

        color: #283041;

        font-weight: 850;
    }

    .erp-programme-meta {
        margin-top: 3px;

        font-size: 14px;

        color: #8f97a5;

        font-weight: 750;

        text-transform: uppercase;

        letter-spacing: .4px;
    }


    .erp-programme-student-count {
        flex-shrink: 0;

        display: inline-flex;

        align-items: center;

        gap: 5px;

        padding: 7px 9px;

        border-radius: 9px;

        background: #effaf5;

        border: 1px solid #d5eee1;

        color: #08784f;

        font-size: 14px;

        font-weight: 850;

        white-space: nowrap;
    }

    .erp-programme-student-count strong {
        font-size: 15px;
    }


    /* =========================================================
       APPLICATION STATUS MINI CARDS
    ========================================================= */

    .erp-application-status {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 6px;

        margin-top: 11px;
    }


    .erp-app-box {
        padding: 8px 6px;

        border-radius: 9px;

        border: 1px solid #eceef3;

        background: #fafbfc;
    }

    .erp-app-box small {
        display: block;

        color: #9299a7;

        font-size: 14px;

        text-transform: uppercase;

        letter-spacing: .3px;

        font-weight: 900;
    }

    .erp-app-box strong {
        display: block;

        margin-top: 3px;

        color: #303849;

        font-size: 14px;

        line-height: 1;

        font-weight: 900;
    }

    .erp-app-applied {
        background: #f7f4ff;
        border-color: #e8e1ff;
    }

    .erp-app-pending {
        background: #fff9ef;
        border-color: #f0dfbb;
    }

    .erp-app-approved {
        background: #effaf5;
        border-color: #d6eee2;
    }

    .erp-app-rejected {
        background: #fff3f4;
        border-color: #f0d6da;
    }


    /* =========================================================
       YEAR STRUCTURE
    ========================================================= */

    .erp-year-grid {
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 7px;

        margin-top: 10px;
    }


    .erp-year-card {
        min-width: 0;

        padding: 9px;

        min-height: 102px;

        border-radius: 11px;

        border: 1px solid #eaecf1;

        background:
            linear-gradient(
                180deg,
                #fbfcfd,
                #f7f8fa
            );
    }


    .erp-year-head {
        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 6px;
    }


    .erp-year-label {
        color: #858d9b;

        font-size: 14px;

        font-weight: 900;

        text-transform: uppercase;

        letter-spacing: .35px;
    }

    .erp-year-total {
        color: #2e3545;

        font-size: 15px;

        line-height: 1;

        font-weight: 900;
    }


    .erp-year-line {
        height: 1px;

        background: #e6e8ed;

        margin: 8px 0;
    }


    .erp-semester-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 5px;
    }


    .erp-semester {
        padding: 6px 4px;

        text-align: center;

        border-radius: 8px;

        background: #ffffff;

        border: 1px solid #eceef2;
    }

    .erp-semester span {
        display: block;

        color: #9299a6;

        font-size: 14px;

        font-weight: 900;

        text-transform: uppercase;
    }

    .erp-semester strong {
        display: block;

        margin-top: 2px;

        color: #343b4b;

        font-size: 14px;

        line-height: 1;

        font-weight: 900;
    }


    .erp-year-note {
        color: #8c94a2;

        font-size: 14px;

        line-height: 1.4;
    }


    /* =========================================================
       LOWER PANELS
    ========================================================= */

    .erp-lower-grid {
        display: grid;

        grid-template-columns:
            1.35fr 1fr;

        gap: 18px;
    }

    .erp-lower-panel {
        background: #ffffff;

        border: 1px solid var(--erp-border);

        border-radius: 18px;

        box-shadow: var(--erp-shadow);

        overflow: hidden;
    }

    .erp-lower-header {
        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 10px;

        padding: 15px 18px;

        border-bottom: 1px solid #edf0f4;
    }

    .erp-lower-header h3 {
        margin: 0;

        font-size: 14px;

        font-weight: 850;

        color: #2d3445;
    }

    .erp-lower-header span {
        font-size: 14px;

        color: #9299a7;

        font-weight: 750;
    }


    /* =========================================================
       RECENT APPLICATIONS
    ========================================================= */

    .erp-recent-list {
        padding: 7px 17px 12px;
    }

    .erp-recent-item {
        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 12px;

        padding: 11px 2px;

        border-bottom: 1px solid #f0f1f4;
    }

    .erp-recent-item:last-child {
        border-bottom: 0;
    }

    .erp-recent-main {
        min-width: 0;
    }

    .erp-recent-name {
        color: #313849;

        font-size: 14px;

        font-weight: 850;

        white-space: nowrap;

        overflow: hidden;

        text-overflow: ellipsis;
    }

    .erp-recent-course {
        margin-top: 3px;

        color: #949ba7;

        font-size: 14px;
    }

    .erp-status-badge {
        flex-shrink: 0;

        padding: 5px 8px;

        border-radius: 999px;

        font-size: 14px;

        font-weight: 900;

        text-transform: uppercase;

        letter-spacing: .3px;
    }

    .erp-badge-submitted {
        background: #fff8e9;
        color: #9c6a06;
        border: 1px solid #f0dfb5;
    }

    .erp-badge-approved {
        background: #eefaf4;
        color: #08784f;
        border: 1px solid #d3eddf;
    }

    .erp-badge-rejected {
        background: #fff2f4;
        color: #b42e42;
        border: 1px solid #efd5da;
    }

    .erp-badge-draft {
        background: #f4f5f7;
        color: #747d8b;
        border: 1px solid #e4e7ec;
    }


    /* =========================================================
       APPLICATION SNAPSHOT
    ========================================================= */

    .erp-snapshot {
        padding: 16px 18px 19px;
    }

    .erp-snapshot-item {
        margin-bottom: 14px;
    }

    .erp-snapshot-item:last-child {
        margin-bottom: 0;
    }

    .erp-snapshot-top {
        display: flex;

        justify-content: space-between;

        align-items: center;

        gap: 8px;

        margin-bottom: 5px;

        color: #6d7583;

        font-size: 14px;

        font-weight: 800;
    }

    .erp-progress {
        width: 100%;

        height: 6px;

        border-radius: 999px;

        background: #edf0f4;

        overflow: hidden;
    }

    .erp-progress-fill {
        height: 100%;

        border-radius: 999px;
    }

    .erp-progress-pending {
        background: linear-gradient(90deg, #f2ba50, #e99b17);
    }

    .erp-progress-approved {
        background: linear-gradient(90deg, #28bf91, #0b9e70);
    }

    .erp-progress-rejected {
        background: linear-gradient(90deg, #fa6d7e, #db495d);
    }

    .erp-total-applications {
        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 10px;

        margin-top: 17px;

        padding-top: 14px;

        border-top: 1px solid #edf0f4;
    }

    .erp-total-applications span {
        color: #8e96a3;

        font-size: 14px;

        font-weight: 800;
    }

    .erp-total-applications strong {
        color: #2b3343;

        font-size: 19px;

        font-weight: 900;
    }


    /* =========================================================
       EMPTY
    ========================================================= */

    .erp-empty {
        padding: 28px 20px;

        text-align: center;

        color: #969eaa;

        font-size: 14px;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1500px) {

        .erp-department-grid {
            grid-template-columns:
                repeat(3, minmax(0, 1fr));
        }
    }


    @media (max-width: 1200px) {

        .erp-metrics {
            grid-template-columns:
                repeat(3, minmax(0, 1fr));
        }

        .erp-department-grid {
            grid-template-columns:
                repeat(3, minmax(0, 1fr));
        }

        .erp-programme-grid {
            grid-template-columns: 1fr;
        }
    }


    @media (max-width: 980px) {

        .erp-department-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

        .erp-lower-grid {
            grid-template-columns: 1fr;
        }
    }


    @media (max-width: 760px) {

        .erp-programme-preview-list {
            grid-template-columns: 1fr;
        }

        .erp-dashboard {
            padding: 15px;
        }

        .erp-page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .erp-metrics {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

        .erp-panel-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .erp-panel-counts {
            justify-content: flex-start;
        }

        .erp-department-grid {
            grid-template-columns: 1fr;

            padding-left: 15px;
            padding-right: 15px;
        }

        .erp-group-strip {
            padding-left: 15px;
            padding-right: 15px;
        }

        .erp-detail-panel {
            margin-left: 15px;
            margin-right: 15px;
        }

        .erp-application-status {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

        .erp-year-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }
    }


    @media (max-width: 480px) {

        .erp-metrics {
            grid-template-columns: 1fr;
        }

        .erp-department-top {
            align-items: center;
        }

        .erp-programme-head {
            flex-direction: column;
        }

        .erp-programme-student-count {
            align-self: flex-start;
        }

        .erp-year-grid {
            grid-template-columns: 1fr;
        }
    }


    /* Final readable sizes for key dashboard elements */
    .erp-page-title h1 { font-size: 28px; }
    .erp-page-title p { font-size: 13px; }
    .erp-session { font-size: 13px; }
    .erp-metric-title { font-size: 13px; }
    .erp-metric-number { font-size: 28px; }
    .erp-panel-title h2 { font-size: 20px; }
    .erp-panel-title p { font-size: 13px; }
    .erp-count-pill { font-size: 12px; }
    .erp-group-strip-label { font-size: 11px; }
    .erp-group-tag { font-size: 11px; }
    .erp-department-logo { font-size: 14px; }
    .erp-department-name h3 { font-size: 15px; }
    .erp-department-group { font-size: 11px; }
    .erp-student-total { font-size: 12px; }
    .erp-student-total strong { font-size: 18px; }


    /* =========================================================
       COLORFUL HD VISUAL REFRESH — PROGRAMME SUMMARY
       Keeps all existing Blade/PHP logic unchanged.
    ========================================================= */

    .erp-dashboard {
        font-family: "Segoe UI", Arial, Helvetica, sans-serif;
        font-size: 15px;
        line-height: 1.55;
        color: #182033;
        background:
            radial-gradient(circle at 12% 5%, rgba(116, 77, 255, .12), transparent 24%),
            radial-gradient(circle at 92% 8%, rgba(0, 196, 204, .10), transparent 22%),
            linear-gradient(180deg, #f8faff 0%, #eef2f9 100%);
    }

    .erp-dashboard * {
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .erp-panel {
        border: 1px solid #dfe5f1 !important;
        box-shadow:
            0 18px 50px rgba(34, 49, 82, .10),
            0 4px 12px rgba(34, 49, 82, .06) !important;
        background: rgba(255,255,255,.98) !important;
    }

    .erp-panel-header {
        padding: 24px 24px 20px !important;
        background:
            linear-gradient(135deg, rgba(104,82,232,.085), rgba(39,196,211,.045) 55%, rgba(255,255,255,0) 100%);
        border-bottom: 1px solid #e4e8f1 !important;
    }

    .erp-panel-title h2 {
        font-size: 24px !important;
        line-height: 1.2 !important;
        font-weight: 900 !important;
        letter-spacing: -.35px;
        color: #1a2440 !important;
    }

    .erp-panel-title p {
        font-size: 15px !important;
        line-height: 1.55 !important;
        color: #66738a !important;
        font-weight: 600 !important;
    }

    .erp-panel-counts {
        gap: 10px !important;
    }

    .erp-count-pill {
        min-height: 42px;
        padding: 9px 13px !important;
        border-radius: 12px !important;
        background: linear-gradient(180deg, #ffffff, #f5f2ff) !important;
        border: 1px solid #ded6ff !important;
        color: #5740ce !important;
        font-size: 14px !important;
        font-weight: 850 !important;
        box-shadow: 0 5px 15px rgba(92,67,212,.07);
    }

    .erp-group-strip {
        padding: 18px 24px 8px !important;
        gap: 9px !important;
    }

    .erp-group-strip-label {
        font-size: 13px !important;
        color: #4e5b73 !important;
        font-weight: 900 !important;
        letter-spacing: .5px;
    }

    .erp-group-tag {
        padding: 8px 12px !important;
        font-size: 13px !important;
        background: linear-gradient(180deg, #fff, #f6f8fc) !important;
        color: #41506b !important;
        border-color: #dce3ef !important;
        box-shadow: 0 3px 9px rgba(43,56,84,.05);
    }

    /* Three wider columns = cleaner labels and stronger visual hierarchy. */
    .erp-department-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        gap: 18px !important;
        padding: 18px 24px 24px !important;
    }

    .erp-department-card {
        min-height: 258px !important;
        border-radius: 21px !important;
        border-width: 1px !important;
        box-shadow:
            0 10px 28px rgba(35,48,77,.08),
            inset 0 1px 0 rgba(255,255,255,.75) !important;
        background:
            radial-gradient(circle at 100% 0%, var(--dept-glow, rgba(104,82,232,.12)), transparent 40%),
            linear-gradient(145deg, #ffffff 0%, var(--dept-bg, #fbfbfe) 100%) !important;
    }

    .erp-department-card::before {
        height: 6px !important;
        background: linear-gradient(90deg, var(--dept-accent), var(--dept-accent-2), rgba(255,255,255,.35)) !important;
    }

    .erp-department-card:hover {
        transform: translateY(-5px) !important;
        box-shadow:
            0 22px 42px rgba(35,48,77,.14),
            0 4px 12px rgba(104,82,232,.08) !important;
    }

    .erp-department-inner {
        padding: 20px !important;
    }

    .erp-department-brand {
        min-width: 0;
        gap: 13px !important;
    }

    .erp-department-logo {
        width: 58px !important;
        height: 58px !important;
        min-width: 58px !important;
        border-radius: 16px !important;
        font-size: 16px !important;
        font-weight: 950 !important;
        color: #fff !important;
        box-shadow:
            0 10px 20px rgba(39,48,81,.18),
            inset 0 1px 0 rgba(255,255,255,.28) !important;
    }

    .erp-department-name h3 {
        font-size: 20px !important;
        line-height: 1.18 !important;
        color: #15203a !important;
        font-weight: 900 !important;
        letter-spacing: -.25px;
    }

    .erp-department-group {
        margin-top: 5px !important;
        font-size: 14px !important;
        line-height: 1.35 !important;
        color: #738097 !important;
        font-weight: 700 !important;
    }

    .erp-student-total {
        min-width: 84px;
        padding: 10px 11px !important;
        border-radius: 12px !important;
        background: linear-gradient(180deg, #f8f5ff, #efeaff) !important;
        border: 1px solid #ddd4ff !important;
        color: #5940d1 !important;
        box-shadow: 0 5px 14px rgba(89,64,209,.07);
    }

    .erp-student-total strong {
        font-size: 23px !important;
        line-height: 1 !important;
        font-weight: 950 !important;
    }

    .erp-student-total span {
        margin-top: 5px !important;
        font-size: 11px !important;
        line-height: 1 !important;
        font-weight: 900 !important;
        letter-spacing: .65px !important;
    }

    .erp-department-stats {
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        gap: 9px !important;
        margin-top: 18px !important;
    }

    .erp-department-stat {
        min-height: 72px;
        padding: 10px 9px !important;
        border-radius: 13px !important;
        border: 1px solid #e2e7f0 !important;
        background: linear-gradient(180deg, #ffffff 0%, #f7f9fc 100%) !important;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.8);
    }

    .erp-department-stat-label {
        display: block !important;
        min-height: 30px;
        font-size: 11px !important;
        line-height: 1.25 !important;
        color: #7b8799 !important;
        font-weight: 900 !important;
        letter-spacing: .35px !important;
        white-space: normal !important;
        overflow: visible !important;
    }

    .erp-department-stat-value {
        margin-top: 4px !important;
        font-size: 20px !important;
        line-height: 1.05 !important;
        color: #19243c !important;
        font-weight: 950 !important;
    }

    .erp-department-stat:nth-child(1) {
        background: linear-gradient(180deg, #f6f3ff, #efeaff) !important;
        border-color: #ddd4ff !important;
    }

    .erp-department-stat:nth-child(2) {
        background: linear-gradient(180deg, #fff8ef, #fff1dd) !important;
        border-color: #f2d8b7 !important;
    }

    .erp-department-stat:nth-child(3) {
        background: linear-gradient(180deg, #eefbff, #e5f7fb) !important;
        border-color: #cdebf1 !important;
    }

    .erp-department-session {
        min-height: 27px !important;
        padding: 4px 9px !important;
        border-radius: 8px !important;
        background: #fff !important;
        border: 1px solid #d7dfe9 !important;
        color: #3f4e67 !important;
        font-size: 13px !important;
        font-weight: 900 !important;
    }

    .erp-programme-preview {
        margin-top: 15px !important;
    }

    .erp-programme-preview-title {
        font-size: 12px !important;
        color: #65738a !important;
        font-weight: 900 !important;
        text-transform: uppercase;
        letter-spacing: .65px;
    }

    .erp-programme-preview-list {
        gap: 7px !important;
        margin-top: 7px !important;
    }

    .erp-programme-chip {
        min-height: 31px;
        padding: 6px 9px !important;
        border-radius: 9px !important;
        background: rgba(255,255,255,.82) !important;
        border: 1px solid #dfe5ee !important;
        box-shadow: 0 3px 8px rgba(42,54,82,.04);
    }

    .erp-course-code {
        font-size: 11px !important;
        font-weight: 950 !important;
        color: #6045cf !important;
    }

    .erp-course-name {
        font-size: 11px !important;
        color: #59677f !important;
        font-weight: 700 !important;
    }

    .erp-detail-button {
        margin-top: 16px !important;
        min-height: 46px !important;
        border-radius: 12px !important;
        font-size: 14px !important;
        font-weight: 900 !important;
        color: #ffffff !important;
        background: linear-gradient(135deg, var(--dept-accent), var(--dept-accent-2)) !important;
        box-shadow: 0 8px 18px rgba(64,55,160,.16) !important;
        border: 0 !important;
    }

    .erp-detail-button:hover {
        filter: brightness(1.04) saturate(1.08);
        transform: translateY(-1px);
    }

    /* Details opened below the grid */
    .erp-detail-panel {
        margin-left: 24px !important;
        margin-right: 24px !important;
        border: 1px solid #dfe5f0 !important;
        border-radius: 18px !important;
        box-shadow: 0 12px 34px rgba(36,47,76,.09) !important;
    }

    .erp-detail-header {
        padding: 16px 18px !important;
        background: linear-gradient(90deg, #f8f6ff, #f4fbff) !important;
    }

    .erp-detail-header-left h3 {
        font-size: 18px !important;
        font-weight: 900 !important;
        color: #1d2943 !important;
    }

    .erp-detail-close {
        width: 36px !important;
        height: 36px !important;
        border-radius: 10px !important;
        font-size: 20px !important;
    }

    .erp-detail-body {
        padding: 18px !important;
    }

    .erp-programme-card {
        padding: 16px !important;
        border-radius: 15px !important;
        border-color: #e2e7f0 !important;
        background: linear-gradient(145deg, #ffffff, #f8faff) !important;
        box-shadow: 0 7px 18px rgba(40,52,82,.055) !important;
    }

    .erp-programme-title {
        font-size: 16px !important;
        color: #18243e !important;
        font-weight: 900 !important;
    }

    .erp-programme-meta {
        font-size: 12px !important;
        color: #748198 !important;
        font-weight: 800 !important;
    }

    .erp-programme-student-count {
        font-size: 12px !important;
        padding: 8px 10px !important;
    }

    .erp-app-box {
        min-height: 68px;
        padding: 9px 7px !important;
        border-radius: 10px !important;
    }

    .erp-app-box small {
        font-size: 10px !important;
        line-height: 1.2 !important;
        color: #718096 !important;
        white-space: normal !important;
    }

    .erp-app-box strong {
        font-size: 17px !important;
        margin-top: 5px !important;
    }

    /* Stronger top-level titles */
    .erp-page-title h1 {
        font-size: 30px !important;
        font-weight: 950 !important;
    }

    .erp-page-title p {
        font-size: 15px !important;
        font-weight: 600 !important;
    }

    /* At normal desktop widths, keep cards readable. */
    @media (max-width: 1450px) {
        .erp-department-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
    }

    @media (max-width: 900px) {
        .erp-department-grid {
            grid-template-columns: 1fr !important;
        }

        .erp-panel-header {
            padding: 20px 18px 16px !important;
        }

        .erp-department-inner {
            padding: 18px !important;
        }
    }



/* =========================================================
   EXECUTIVE DASHBOARD REFRESH — UI ONLY
   Existing Blade data variables, routes and business logic stay intact.
========================================================= */
.erp-dashboard{font-family:Inter,"Segoe UI",Roboto,Arial,sans-serif!important;background:#f4f6fb!important;color:#172033!important;padding:26px!important;min-height:calc(100vh - 64px)}
.erp-dashboard-inner{max-width:1900px!important}
.erp-page-header{padding:4px 0 22px!important;margin-bottom:20px!important;border-bottom:1px solid #e5eaf3;align-items:center}
.erp-page-title h1{font-size:30px!important;letter-spacing:-1px!important;font-weight:850!important;color:#172033!important}
.erp-page-title p{font-size:14px!important;color:#778198!important;font-weight:500!important}
.erp-session{border:1px solid #e4e8f2!important;border-radius:14px!important;padding:12px 16px!important;background:#fff!important;color:#4f46e5!important;box-shadow:0 8px 24px rgba(20,31,56,.045)!important;font-size:13px!important}
.erp-metrics{grid-template-columns:repeat(4,minmax(0,1fr))!important;gap:18px!important;margin-bottom:22px!important}
.erp-metric{border:1px solid #e6eaf2!important;border-radius:20px!important;background:#fff!important;box-shadow:0 8px 24px rgba(24,39,75,.045)!important;overflow:hidden;transition:transform .2s ease,box-shadow .2s ease!important;min-height:150px}
.erp-metric:hover{transform:translateY(-3px);box-shadow:0 15px 35px rgba(24,39,75,.09)!important}
.erp-metric-content{padding:22px!important}
.erp-metric-icon{width:46px!important;height:46px!important;border-radius:15px!important;display:grid!important;place-items:center!important;font-size:22px!important;margin-bottom:16px!important;background:#f1efff!important}
.erp-metric-title{font-size:13px!important;font-weight:650!important;color:#7b8498!important;letter-spacing:.1px!important}
.erp-metric-number{font-size:31px!important;font-weight:850!important;letter-spacing:-1px!important;color:#172033!important;margin-top:5px!important;line-height:1.15!important}
.erp-panel{border:1px solid #e4e9f2!important;border-radius:22px!important;background:#fff!important;box-shadow:0 10px 32px rgba(24,39,75,.05)!important;overflow:hidden!important;margin-bottom:22px!important}
.erp-panel-header{padding:23px 25px!important;border-bottom:1px solid #edf0f6!important;background:linear-gradient(115deg,#fff 0%,#fafbff 100%)!important}
.erp-panel-title h2{font-size:20px!important;font-weight:800!important;letter-spacing:-.4px!important;color:#172033!important}
.erp-panel-title p{font-size:13px!important;color:#7c879b!important;font-weight:500!important}
.erp-panel-counts{gap:8px!important}.erp-count-pill{border-radius:12px!important;padding:9px 12px!important;font-size:12px!important;font-weight:750!important;background:#f6f7fb!important;border:1px solid #e7eaf2!important;box-shadow:none!important}
.erp-group-strip{padding:18px 25px 8px!important}.erp-group-tag{border-radius:999px!important;padding:7px 11px!important;background:#f3f1ff!important;color:#5845c7!important;border:1px solid #e5e0ff!important;font-weight:700!important}
.erp-department-grid{gap:16px!important;padding:20px 25px 25px!important}
.erp-department-card{border:1px solid #e4e9f2!important;border-radius:18px!important;box-shadow:0 6px 20px rgba(24,39,75,.04)!important;overflow:hidden!important;transition:transform .2s ease,box-shadow .2s ease!important}
.erp-department-card:hover{transform:translateY(-2px);box-shadow:0 12px 28px rgba(24,39,75,.09)!important}
.erp-department-inner{padding:20px!important}.erp-department-name h3{font-size:16px!important;font-weight:800!important;color:#172033!important}
.erp-programme-card{border:1px solid #e7ebf3!important;border-radius:15px!important;box-shadow:0 5px 16px rgba(24,39,75,.035)!important}
.erp-detail-panel{border-radius:18px!important;border:1px solid #e2e8f3!important;box-shadow:0 12px 35px rgba(24,39,75,.08)!important}
.erp-detail-button{border-radius:11px!important;font-weight:750!important}
.erp-dashboard a{transition:color .18s ease,background .18s ease}
.erp-chart-grid{display:grid;grid-template-columns:minmax(0,1.35fr) minmax(300px,.9fr);gap:18px;margin:0 0 22px}
.erp-chart-card{min-width:0;background:#fff;border:1px solid #e4e9f2;border-radius:22px;padding:23px;box-shadow:0 10px 32px rgba(24,39,75,.045)}
.erp-chart-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:18px}
.erp-chart-title{font-size:17px;font-weight:800;color:#172033;letter-spacing:-.3px}
.erp-chart-subtitle{font-size:12px;color:#8791a4;margin-top:5px}
.erp-chart-tag{font-size:11px;font-weight:750;color:#6554d9;background:#f2f0ff;border:1px solid #e7e2ff;border-radius:999px;padding:7px 10px;white-space:nowrap}
.erp-chart-wrap{height:275px;position:relative}.erp-chart-wrap canvas{max-width:100%}
.erp-insight-row{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px;margin-top:14px}
.erp-insight{background:#f8f9fc;border:1px solid #edf0f6;border-radius:13px;padding:12px}
.erp-insight span{display:block;font-size:11px;color:#8791a4;font-weight:650}.erp-insight strong{display:block;font-size:19px;color:#172033;margin-top:5px;font-weight:850}
@media(max-width:1200px){.erp-metrics{grid-template-columns:repeat(3,minmax(0,1fr))!important}.erp-chart-grid{grid-template-columns:1fr}}
@media(max-width:760px){.erp-dashboard{padding:14px!important}.erp-metrics{grid-template-columns:repeat(2,minmax(0,1fr))!important;gap:10px!important}.erp-metric-content{padding:16px!important}.erp-metric-number{font-size:25px!important}.erp-chart-card{padding:16px;border-radius:17px}.erp-chart-wrap{height:240px}.erp-insight-row{grid-template-columns:1fr}.erp-page-title h1{font-size:25px!important}}
@media(max-width:420px){.erp-metrics{grid-template-columns:1fr!important}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


/* =========================================================
   PREMIUM ADMIN DASHBOARD — COLOUR, ICONS & NAVIGATION
   Visual-only overrides; no routes, queries, variables or forms changed.
========================================================= */
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Manrope:wght@500;600;700;800&display=swap');
.erp-dashboard,.erp-dashboard *{font-family:'DM Sans',Inter,'Segoe UI',sans-serif!important}
.erp-dashboard{background:radial-gradient(circle at 7% 0%,rgba(124,92,255,.08),transparent 28%),#f4f6fc!important;padding:30px!important}
.erp-dashboard-inner{max-width:1900px!important}
.erp-page-header{padding:8px 0 26px!important;margin-bottom:24px!important;border-bottom:1px solid #e4e8f2!important}
.erp-page-title h1{font-family:Manrope,'DM Sans',sans-serif!important;font-size:34px!important;font-weight:800!important;letter-spacing:-1.2px!important;color:#171d36!important}
.erp-page-title p{font-size:14px!important;color:#78829a!important}
.erp-session{background:linear-gradient(135deg,#fff,#f3f0ff)!important;border:1px solid #ded8ff!important;color:#5542c4!important;border-radius:15px!important;padding:13px 17px!important;box-shadow:0 10px 28px rgba(83,64,190,.08)!important}
.erp-metrics{grid-template-columns:repeat(4,minmax(0,1fr))!important;gap:20px!important;margin-bottom:26px!important}
.erp-metric{position:relative!important;min-height:190px!important;border:0!important;border-radius:23px!important;color:#fff!important;box-shadow:0 15px 32px rgba(37,45,89,.13)!important;overflow:hidden!important;isolation:isolate!important}
.erp-metric::before{content:''!important;position:absolute!important;width:180px!important;height:180px!important;right:-48px!important;top:-85px!important;border-radius:50%!important;background:rgba(255,255,255,.15)!important;z-index:-1!important}
.erp-metric::after{content:''!important;position:absolute!important;width:115px!important;height:115px!important;right:45px!important;bottom:-78px!important;border-radius:50%!important;background:rgba(255,255,255,.09)!important;z-index:-1!important}
.erp-metric:hover{transform:translateY(-5px)!important;box-shadow:0 22px 42px rgba(37,45,89,.2)!important}
.erp-metric.metric-purple{background:linear-gradient(135deg,#8b5cf6 0%,#5b35cb 100%)!important}
.erp-metric.metric-orange{background:linear-gradient(135deg,#ffbd66 0%,#f07835 100%)!important}
.erp-metric.metric-green{background:linear-gradient(135deg,#34d399 0%,#059669 100%)!important}
.erp-metric.metric-blue{background:linear-gradient(135deg,#60a5fa 0%,#2563eb 100%)!important}
.erp-metric.metric-indigo{background:linear-gradient(135deg,#818cf8 0%,#4f46e5 100%)!important}
.erp-metric.metric-red{background:linear-gradient(135deg,#fb7185 0%,#e11d48 100%)!important}
.erp-metric.metric-cyan{background:linear-gradient(135deg,#22d3ee 0%,#0e7490 100%)!important}
.erp-metric-content{padding:25px!important;position:relative!important;z-index:2!important}
.erp-metric-icon{width:54px!important;height:54px!important;border-radius:17px!important;display:flex!important;align-items:center!important;justify-content:center!important;margin-bottom:19px!important;background:rgba(255,255,255,.19)!important;border:1px solid rgba(255,255,255,.27)!important;box-shadow:inset 0 1px rgba(255,255,255,.22),0 8px 18px rgba(25,25,70,.09)!important;color:#fff!important;font-size:24px!important;backdrop-filter:blur(8px)!important}
.erp-metric-icon i{font-size:24px!important;line-height:1!important}
.erp-metric-title{font-size:13px!important;font-weight:700!important;letter-spacing:.15px!important;color:rgba(255,255,255,.9)!important;opacity:1!important;margin-top:0!important}
.erp-metric-number{font-family:Manrope,'DM Sans',sans-serif!important;font-size:37px!important;line-height:1.1!important;font-weight:800!important;letter-spacing:-1.2px!important;color:#fff!important;margin-top:7px!important}
.erp-chart-card,.erp-panel{border:1px solid #e4e8f3!important;border-radius:24px!important;box-shadow:0 12px 34px rgba(32,43,83,.055)!important}
.erp-chart-card{padding:25px!important;background:linear-gradient(180deg,#fff 0%,#fdfdff 100%)!important}
.erp-chart-title,.erp-panel-title h2{font-family:Manrope,'DM Sans',sans-serif!important;font-weight:800!important;color:#1c2340!important}
.erp-chart-tag{background:#f0edff!important;color:#5b43c7!important;border-color:#e3dcff!important}
.erp-panel-header{background:linear-gradient(110deg,#fff,#f8f7ff)!important}

/* Shared admin sidebar/navigation: only active when the layout uses these common classes. */
.sidebar,.main-sidebar,.admin-sidebar,.app-sidebar,aside.sidebar{background:linear-gradient(180deg,#22204e 0%,#302b70 52%,#24204f 100%)!important;color:#eef0ff!important;border-right:0!important;box-shadow:8px 0 30px rgba(29,26,80,.12)!important}
.sidebar .side-title,.sidebar .sidebar-title,.sidebar .menu-title,.main-sidebar .menu-title,.admin-sidebar .menu-title{color:#aeb3f7!important;font-size:10px!important;font-weight:800!important;letter-spacing:1.2px!important;text-transform:uppercase!important;padding:16px 18px 8px!important}
.sidebar a,.main-sidebar a,.admin-sidebar a,.app-sidebar a,aside.sidebar a,.sidebar button{color:#e5e7ff!important;border-radius:11px!important;transition:background .18s ease,color .18s ease,transform .18s ease!important}
.sidebar a:hover,.main-sidebar a:hover,.admin-sidebar a:hover,.app-sidebar a:hover,aside.sidebar a:hover{background:rgba(255,255,255,.12)!important;color:#fff!important;transform:translateX(2px)}
.sidebar a.active,.sidebar .active>a,.sidebar a[aria-current="page"],.main-sidebar a.active,.admin-sidebar a.active{background:linear-gradient(100deg,rgba(139,124,255,.32),rgba(255,255,255,.1))!important;color:#fff!important;box-shadow:inset 3px 0 #b5a8ff!important}
.sidebar a i,.sidebar a svg,.main-sidebar a i,.main-sidebar a svg,.admin-sidebar a i,.admin-sidebar a svg{color:#bdb5ff!important;min-width:19px!important;font-size:16px!important;vertical-align:middle!important}
.sidebar .badge,.main-sidebar .badge,.admin-sidebar .badge{background:rgba(255,255,255,.15)!important;color:#fff!important;border:1px solid rgba(255,255,255,.1)!important;border-radius:7px!important}
@media(max-width:1250px){.erp-metrics{grid-template-columns:repeat(3,minmax(0,1fr))!important}}
@media(max-width:900px){.erp-dashboard{padding:20px!important}.erp-metrics{grid-template-columns:repeat(2,minmax(0,1fr))!important}.erp-metric{min-height:170px!important}.erp-metric-number{font-size:33px!important}}
@media(max-width:520px){.erp-dashboard{padding:13px!important}.erp-metrics{grid-template-columns:1fr!important;gap:13px!important}.erp-metric{min-height:145px!important}.erp-metric-content{padding:20px!important}.erp-metric-icon{margin-bottom:12px!important}.erp-page-title h1{font-size:26px!important}}


    /* Compact executive cards: retain colours, improve dashboard density */
    .erp-dashboard { padding: 18px !important; }
    .erp-metrics { gap: 12px !important; margin-bottom: 16px !important; }
    .erp-metric {
        min-height: 104px !important;
        padding: 14px 15px !important;
        border-radius: 15px !important;
    }
    .erp-metric-icon {
        width: 34px !important;
        height: 34px !important;
        border-radius: 10px !important;
        font-size: 17px !important;
    }
    .erp-metric-title {
        margin-top: 8px !important;
        font-size: 12px !important;
        line-height: 1.35 !important;
        font-weight: 750 !important;
    }
    .erp-metric-number {
        margin-top: 4px !important;
        font-size: 23px !important;
        line-height: 1.05 !important;
    }
    .erp-panel { border-radius: 16px !important; margin-bottom: 16px !important; }
    .erp-panel-header { padding: 15px 18px !important; }
    .erp-panel-title h2 { font-size: 16px !important; }
    .erp-panel-title p { font-size: 12px !important; }
    @media (min-width: 1201px) {
        .erp-metrics { grid-template-columns: repeat(4, minmax(0, 1fr)) !important; }
    }
    @media (max-width: 760px) {
        .erp-dashboard { padding: 12px !important; }
        .erp-metric { min-height: 100px !important; padding: 12px !important; }
        .erp-metric-number { font-size: 21px !important; }
    }

</style>


@php
    /*
    |--------------------------------------------------------------------------
    | Prepare one flat department collection.
    |--------------------------------------------------------------------------
    |
    | This is deliberately done in normal PHP rather than complex nested
    | Blade @foreach expressions. It keeps Laravel Blade compilation safe.
    |
    */

    $dashboardDepartments = collect();
    $departmentGroupNames = collect();

    foreach ($programGroups as $programGroup) {

        foreach ($programGroup->departments as $department) {

            if (!$department->is_active) {
                continue;
            }

            $departmentName = strtolower($department->name);

            $logoClass = 'dept-default';
            $logoText = strtoupper(substr($department->name, 0, 2));

            if (str_contains($departmentName, 'computer')) {
                $logoClass = 'dept-cs';
                $logoText = 'CS';
            } elseif (str_contains($departmentName, 'commerce')) {
                $logoClass = 'dept-commerce';
                $logoText = 'CO';
            } elseif (str_contains($departmentName, 'arts')) {
                $logoClass = 'dept-arts';
                $logoText = 'AR';
            } elseif ($departmentName === 'science' || str_starts_with($departmentName, 'science ')) {
                $logoClass = 'dept-science';
                $logoText = 'SC';
            } elseif (str_contains($departmentName, 'post')) {
                $logoClass = 'dept-pg';
                $logoText = 'PG';
            } elseif (str_contains($departmentName, 'education')) {
                $logoClass = 'dept-education';
                $logoText = 'ED';
            } elseif (str_contains($departmentName, 'pharmacy')) {
                $logoClass = 'dept-pharmacy';
                $logoText = 'PH';
            } elseif (str_contains($departmentName, 'nursing')) {
                $logoClass = 'dept-nursing';
                $logoText = 'NU';
            }

            $departmentApplications = 0;
            $departmentProgrammes = 0;
            $programmePreview = collect();

            foreach ($department->subDepartments as $subDepartment) {

                foreach ($subDepartment->courses as $course) {

                    $departmentProgrammes++;

                    $departmentApplications +=
                        (int) ($course->dashboard_total ?? 0);

                    $programmePreview->push($course);
                }
            }

            $department->dashboard_group_name = $programGroup->name;
            $department->dashboard_logo_class = $logoClass;
            $department->dashboard_logo_text = $logoText;
            $department->dashboard_application_total = $departmentApplications;
            $department->dashboard_programme_total = $departmentProgrammes;
            $department->dashboard_programme_preview = $programmePreview->take(4);

            $dashboardDepartments->push($department);

            $departmentGroupNames->push($programGroup->name);
        }
    }

    $departmentGroupNames =
        $departmentGroupNames
            ->unique()
            ->values();
@endphp


<div class="erp-dashboard">

    <div class="erp-dashboard-inner">


        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <div class="erp-page-header">

            <div class="erp-page-title">

                <h1>
                    Admin Dashboard
                </h1>

                <p>
                    College ERP overview, academic programmes,
                    applications and student strength
                </p>

            </div>


            <div class="erp-session">

                <span class="erp-session-dot"></span>

                Academic Session:
                {{ $activeSessionName }}

            </div>

        </div>



        {{-- =====================================================
             TOP METRICS
        ====================================================== --}}

        <div class="erp-metrics">


            <div class="erp-metric metric-purple">

                <div class="erp-metric-content">

                    <div class="erp-metric-icon"><i class="bi bi-calendar2-check" aria-hidden="true"></i></div>

                    <div class="erp-metric-title">
                        Today's Applications
                    </div>

                    <div class="erp-metric-number">
                        {{ $todayApplications }}
                    </div>

                </div>

            </div>



            <div class="erp-metric metric-orange">

                <div class="erp-metric-content">

                    <div class="erp-metric-icon"><i class="bi bi-hourglass-split" aria-hidden="true"></i></div>

                    <div class="erp-metric-title">
                        Pending Verification
                    </div>

                    <div class="erp-metric-number">
                        {{ $submittedApplications }}
                    </div>

                </div>

            </div>



            <div class="erp-metric metric-green">

                <div class="erp-metric-content">

                    <div class="erp-metric-icon"><i class="bi bi-patch-check-fill" aria-hidden="true"></i></div>

                    <div class="erp-metric-title">
                        Approved Applications
                    </div>

                    <div class="erp-metric-number">
                        {{ $approvedApplications }}
                    </div>

                </div>

            </div>



            <div class="erp-metric metric-blue">

                <div class="erp-metric-content">

                    <div class="erp-metric-icon"><i class="bi bi-person-workspace" aria-hidden="true"></i></div>

                    <div class="erp-metric-title">
                        Total Staff
                    </div>

                    <div class="erp-metric-number">
                        {{ $totalStaff }}
                    </div>

                </div>

            </div>



            <div class="erp-metric metric-indigo">

                <div class="erp-metric-content">

                    <div class="erp-metric-icon"><i class="bi bi-journal-bookmark-fill" aria-hidden="true"></i></div>

                    <div class="erp-metric-title">
                        Total Courses
                    </div>

                    <div class="erp-metric-number">
                        {{ $totalCourses }}
                    </div>

                </div>

            </div>



            <div class="erp-metric metric-red">

                <div class="erp-metric-content">

                    <div class="erp-metric-icon"><i class="bi bi-mortarboard-fill" aria-hidden="true"></i></div>

                    <div class="erp-metric-title">
                        Total Students
                    </div>

                    <div class="erp-metric-number">
                        {{ $totalStudents }}
                    </div>

                </div>

            </div>



            <div class="erp-metric metric-cyan">

                <div class="erp-metric-content">

                    <div class="erp-metric-icon"><i class="bi bi-clipboard-data-fill" aria-hidden="true"></i></div>

                    <div class="erp-metric-title">
                        Total Applications
                    </div>

                    <div class="erp-metric-number">
                        {{ $totalApplications }}
                    </div>

                </div>

            </div>


        </div>



        {{-- =====================================================
             EXECUTIVE ANALYTICS (read-only presentation)
        ====================================================== --}}
        <section class="erp-chart-grid" aria-label="Dashboard analytics">
            <div class="erp-chart-card">
                <div class="erp-chart-head">
                    <div><div class="erp-chart-title">Department performance</div><div class="erp-chart-subtitle">Student strength and application activity by department</div></div>
                    <span class="erp-chart-tag">Live dashboard data</span>
                </div>
                <div class="erp-chart-wrap"><canvas id="erpDepartmentChart" aria-label="Department performance chart"></canvas></div>
            </div>
            <div class="erp-chart-card">
                <div class="erp-chart-head">
                    <div><div class="erp-chart-title">Application overview</div><div class="erp-chart-subtitle">Current totals from the existing dashboard controller</div></div>
                    <span class="erp-chart-tag">Overview</span>
                </div>
                <div class="erp-chart-wrap"><canvas id="erpApplicationChart" aria-label="Application status chart"></canvas></div>
                <div class="erp-insight-row">
                    <div class="erp-insight"><span>Total students</span><strong>{{ number_format((int) $totalStudents) }}</strong></div>
                    <div class="erp-insight"><span>Total teachers / staff</span><strong>{{ number_format((int) $totalStaff) }}</strong></div>
                    <div class="erp-insight"><span>Programmes</span><strong>{{ number_format((int) $totalCourses) }}</strong></div>
                </div>
            </div>
        </section>

        {{-- =====================================================
             PROGRAMME SUMMARY
        ====================================================== --}}

        
        {{-- REAL-TIME ANALYTICS --}}
        <style>
            .erp-analytics-grid{display:grid;grid-template-columns:minmax(0,1.45fr) minmax(0,1fr);gap:20px;margin:24px 0}
            .erp-analytics-card{min-width:0;background:#fff;border:1px solid #e8eaf2;border-radius:18px;padding:22px;box-shadow:0 8px 26px rgba(31,41,55,.055)}
            .erp-analytics-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:18px}
            .erp-analytics-head h2{font-size:16px;font-weight:750;color:#202637;margin:0}
            .erp-analytics-head p{font-size:12px;color:#7d8798;margin:5px 0 0}
            .erp-analytics-tag{font-size:11px;font-weight:700;color:#5145cd;background:#f1efff;padding:6px 9px;border-radius:999px;white-space:nowrap}
            .erp-chart-wrap{position:relative;height:290px;width:100%}
            @media(max-width:1000px){.erp-analytics-grid{grid-template-columns:1fr}}
            @media(max-width:600px){.erp-analytics-card{padding:15px}.erp-chart-wrap{height:250px}.erp-analytics-grid{gap:14px}}
        </style>
        <section class="erp-analytics-grid" aria-label="Dashboard analytics">
            <article class="erp-analytics-card">
                <div class="erp-analytics-head">
                    <div>
                        <h2>Admissions activity</h2>
                        <p>Applications created each day over the last 14 days</p>
                    </div>
                    <span class="erp-analytics-tag">14 DAYS</span>
                </div>
                <div class="erp-chart-wrap"><canvas id="admissionsTrendChart" aria-label="Admissions trend line chart"></canvas></div>
            </article>
            <article class="erp-analytics-card">
                <div class="erp-analytics-head">
                    <div>
                        <h2>Student strength by programme</h2>
                        <p>Active enrolments in the current academic session</p>
                    </div>
                    <span class="erp-analytics-tag">TOP 10</span>
                </div>
                <div class="erp-chart-wrap"><canvas id="courseStrengthChart" aria-label="Student strength by programme bar chart"></canvas></div>
            </article>
        </section>
<div class="erp-panel">


            <div class="erp-panel-header">

                <div class="erp-panel-title">

                    <h2>
                        Programme Summary
                    </h2>

                    <p>
                        All departments are shown together.
                        Select any department to view programme
                        and year / semester-wise strength.
                    </p>

                </div>


                <div class="erp-panel-counts">

                    <div class="erp-count-pill">
                        🏫
                        {{ $dashboardDepartments->count() }}
                        Departments
                    </div>

                    <div class="erp-count-pill">
                        📚
                        {{ $totalCourses }}
                        Programmes
                    </div>

                    <div class="erp-count-pill">
                        🎓
                        {{ $totalStudents }}
                        Students
                    </div>

                </div>

            </div>



            {{-- =================================================
                 GROUP LEGEND
            ================================================== --}}

            @if($departmentGroupNames->count() > 0)

                <div class="erp-group-strip">

                    <span class="erp-group-strip-label">
                        Programme Groups
                    </span>

                    @foreach($departmentGroupNames as $groupName)

                        <span class="erp-group-tag">
                            {{ $groupName }}
                        </span>

                    @endforeach

                </div>

            @endif



            {{-- =================================================
                 ALL DEPARTMENTS IN ONE GRID
            ================================================== --}}

            @if($dashboardDepartments->count() > 0)

                <div class="erp-department-grid">


                    @foreach($dashboardDepartments as $department)

                        @php
                            $departmentTheme = match($department->dashboard_logo_class) {
                                'dept-cs' => 'theme-cs',
                                'dept-commerce' => 'theme-commerce',
                                'dept-arts' => 'theme-arts',
                                'dept-science' => 'theme-science',
                                'dept-pg' => 'theme-pg',
                                'dept-education' => 'theme-education',
                                'dept-pharmacy' => 'theme-pharmacy',
                                'dept-nursing' => 'theme-nursing',
                                default => 'theme-default',
                            };
                        @endphp

                        <div class="erp-department-card {{ $departmentTheme }}">

                            <div class="erp-department-inner">


                                <div class="erp-department-top">


                                    <div class="erp-department-brand">


                                        <div
                                            class="
                                                erp-department-logo
                                                {{ $department->dashboard_logo_class }}
                                            "
                                        >

                                            <span>
                                                {{ $department->dashboard_logo_text }}
                                            </span>

                                        </div>


                                        <div class="erp-department-name">

                                            <h3>
                                                {{ $department->name }}
                                            </h3>

                                            <div class="erp-department-group">

                                                {{ $department->dashboard_group_name }}

                                            </div>

                                        </div>


                                    </div>



                                    <div class="erp-student-total">

                                        <strong>
                                            {{ $department->dashboard_student_total ?? 0 }}
                                        </strong>

                                        <span>
                                            Students
                                        </span>

                                    </div>


                                </div>



                                {{-- Department statistics --}}

                                <div class="erp-department-stats">


                                    <div class="erp-department-stat">

                                        <div class="erp-department-stat-label">
                                            Programmes
                                        </div>

                                        <div class="erp-department-stat-value">
                                            {{ $department->dashboard_programme_total ?? 0 }}
                                        </div>

                                    </div>



                                    <div class="erp-department-stat">

                                        <div class="erp-department-stat-label">
                                            Applications
                                        </div>

                                        <div class="erp-department-stat-value">
                                            {{ $department->dashboard_application_total ?? 0 }}
                                        </div>

                                    </div>



                                    <div class="erp-department-stat">

                                        <div class="erp-department-stat-label">
                                            Session
                                        </div>

                                        <div class="erp-department-stat-value">
                                            <span class="erp-department-session">
                                                {{ $activeSessionName }}
                                            </span>
                                        </div>

                                    </div>


                                </div>



                                {{-- Programme preview --}}

                                @if($department->dashboard_programme_preview->count() > 0)

                                    <div class="erp-programme-preview">

                                        <div class="erp-programme-preview-title">
                                            Programmes
                                        </div>

                                        <div class="erp-programme-preview-list">

                                            @foreach($department->dashboard_programme_preview as $previewCourse)

                                                <span
                                                    class="erp-programme-chip"
                                                    title="{{ $previewCourse->name }}"
                                                >

                                                    <span class="erp-course-code">
                                                        {{ $previewCourse->code }}
                                                    </span>

                                                    <span class="erp-course-name">
                                                        {{ $previewCourse->name }}
                                                    </span>

                                                </span>

                                            @endforeach

                                        </div>

                                    </div>

                                @endif



                                {{-- View details --}}

                                @php
                                    $detailId =
                                        'erp-detail-' .
                                        $department->id;
                                @endphp


                                <button
                                    type="button"
                                    class="erp-detail-button"
                                    aria-expanded="false"
                                    aria-controls="{{ $detailId }}"
                                    onclick="
                                        toggleERPDepartment(
                                            '{{ $detailId }}',
                                            this
                                        )
                                    "
                                >

                                    <span class="erp-detail-text">
                                        View Details
                                    </span>

                                    <span class="erp-detail-arrow">
                                        ▼
                                    </span>

                                </button>


                            </div>

                        </div>

                    @endforeach


                </div>


            @else

                <div class="erp-empty">
                    No active departments are available.
                </div>

            @endif



            {{-- =================================================
                 SHARED DETAIL PANELS
            ================================================== --}}

            @foreach($dashboardDepartments as $department)

                @php
                    $detailId =
                        'erp-detail-' .
                        $department->id;
                @endphp


                <div
                    id="{{ $detailId }}"
                    class="erp-detail-panel"
                    data-erp-detail-panel="true"
                >


                    <div class="erp-detail-header">


                        <div class="erp-detail-header-left">

                            <span class="erp-detail-heading-dot"></span>

                            <h3>
                                {{ $department->name }}
                                — Programme Details
                            </h3>

                        </div>


                        <button
                            type="button"
                            class="erp-detail-close"
                            title="Close"
                            onclick="
                                closeERPDepartment(
                                    '{{ $detailId }}'
                                )
                            "
                        >
                            ×
                        </button>


                    </div>



                    <div class="erp-detail-body">


                        @php
                            $departmentHasProgrammes = false;
                        @endphp


                        <div class="erp-programme-grid">


                            @foreach($department->subDepartments as $subDepartment)

                                @foreach($subDepartment->courses as $course)

                                    @php
                                        $departmentHasProgrammes = true;

                                        $courseYears =
                                            $course->years
                                                ->where(
                                                    'is_active',
                                                    true
                                                )
                                                ->sortBy(
                                                    'year_number'
                                                );

                                        $studentTotal =
                                            (int)
                                            (
                                                $course
                                                    ->dashboard_student_total
                                                ?? 0
                                            );

                                        $yearStats =
                                            $course
                                                ->dashboard_year_stats
                                            ?? [];
                                    @endphp


                                    <div class="erp-programme-card">


                                        {{-- Programme header --}}

                                        <div class="erp-programme-head">


                                            <div>

                                                <h4 class="erp-programme-title">
                                                    {{ $course->name }}
                                                </h4>

                                                <div class="erp-programme-meta">

                                                    {{ $course->code }}

                                                    @if($course->duration)
                                                        ·
                                                        {{ $course->duration }}
                                                    @endif

                                                </div>

                                            </div>


                                            <div
                                                class="
                                                    erp-programme-student-count
                                                "
                                            >

                                                👨‍🎓

                                                <strong>
                                                    {{ $studentTotal }}
                                                </strong>

                                                Students

                                            </div>


                                        </div>



                                        {{-- Application Status --}}

                                        <div class="erp-application-status">


                                            <div
                                                class="
                                                    erp-app-box
                                                    erp-app-applied
                                                "
                                            >

                                                <small>
                                                    Applied
                                                </small>

                                                <strong>
                                                    {{ $course->dashboard_applied ?? 0 }}
                                                </strong>

                                            </div>


                                            <div
                                                class="
                                                    erp-app-box
                                                    erp-app-pending
                                                "
                                            >

                                                <small>
                                                    Pending
                                                </small>

                                                <strong>
                                                    {{ $course->dashboard_pending ?? 0 }}
                                                </strong>

                                            </div>


                                            <div
                                                class="
                                                    erp-app-box
                                                    erp-app-approved
                                                "
                                            >

                                                <small>
                                                    Approved
                                                </small>

                                                <strong>
                                                    {{ $course->dashboard_approved ?? 0 }}
                                                </strong>

                                            </div>


                                            <div
                                                class="
                                                    erp-app-box
                                                    erp-app-rejected
                                                "
                                            >

                                                <small>
                                                    Rejected
                                                </small>

                                                <strong>
                                                    {{ $course->dashboard_rejected ?? 0 }}
                                                </strong>

                                            </div>


                                        </div>



                                        {{-- Year / Semester Structure --}}

                                        @if($courseYears->count() > 0)


                                            <div class="erp-year-grid">


                                                @foreach($courseYears as $courseYear)

                                                    @php

                                                        $yearNumber =
                                                            (int)
                                                            $courseYear
                                                                ->year_number;

                                                        $yearData =
                                                            $yearStats[
                                                                $yearNumber
                                                            ]
                                                            ??
                                                            [
                                                                'total' => 0,
                                                                'semesters' => []
                                                            ];

                                                        $yearTotal =
                                                            (int)
                                                            (
                                                                $yearData[
                                                                    'total'
                                                                ]
                                                                ??
                                                                0
                                                            );

                                                        $semesterStats =
                                                            $yearData[
                                                                'semesters'
                                                            ]
                                                            ??
                                                            [];

                                                    @endphp


                                                    <div class="erp-year-card">


                                                        <div class="erp-year-head">

                                                            <div class="erp-year-label">
                                                                Year
                                                                {{ $yearNumber }}
                                                            </div>

                                                            <div class="erp-year-total">
                                                                {{ $yearTotal }}
                                                            </div>

                                                        </div>


                                                        <div class="erp-year-line"></div>



                                                        @if(
                                                            $course->study_pattern
                                                            ===
                                                            'semester'
                                                        )

                                                            @php
                                                                $semesterRows =
                                                                    $courseYear
                                                                        ->semesters
                                                                        ->where(
                                                                            'is_active',
                                                                            true
                                                                        )
                                                                        ->sortBy(
                                                                            'semester_id'
                                                                        );
                                                            @endphp


                                                            @if($semesterRows->count() > 0)


                                                                <div
                                                                    class="
                                                                        erp-semester-grid
                                                                    "
                                                                >


                                                                    @foreach($semesterRows as $yearSemester)

                                                                        @php
                                                                            $semester =
                                                                                $yearSemester
                                                                                    ->semester;

                                                                            $semesterId =
                                                                                $semester?->id;

                                                                            $semesterNumber =
                                                                                $semester?->semester_number
                                                                                ?? null;

                                                                            $semesterCount =
                                                                                $semesterId
                                                                                ? (
                                                                                    $semesterStats[
                                                                                        $semesterId
                                                                                    ]
                                                                                    ??
                                                                                    0
                                                                                )
                                                                                : 0;
                                                                        @endphp


                                                                        <div class="erp-semester">

                                                                            <span>

                                                                                @if($semesterNumber)

                                                                                    Sem
                                                                                    {{ $semesterNumber }}

                                                                                @else

                                                                                    Semester

                                                                                @endif

                                                                            </span>

                                                                            <strong>
                                                                                {{ $semesterCount }}
                                                                            </strong>

                                                                        </div>


                                                                    @endforeach


                                                                </div>


                                                            @else

                                                                <div class="erp-year-note">
                                                                    Semester structure not assigned.
                                                                </div>

                                                            @endif


                                                        @else


                                                            <div class="erp-year-note">

                                                                Year-wise programme

                                                                <br>

                                                                Students:
                                                                <strong>
                                                                    {{ $yearTotal }}
                                                                </strong>

                                                            </div>


                                                        @endif


                                                    </div>


                                                @endforeach


                                            </div>


                                        @else


                                            <div
                                                class="erp-year-note"
                                                style="
                                                    margin-top:10px;
                                                    padding:10px;
                                                    border:1px dashed #dfe3ea;
                                                    border-radius:10px;
                                                    background:#fbfcfd;
                                                "
                                            >
                                                Academic year structure has not
                                                been configured for this programme.
                                            </div>


                                        @endif


                                    </div>


                                @endforeach

                            @endforeach


                        </div>



                        @if(!$departmentHasProgrammes)

                            <div class="erp-empty">
                                No active programmes are configured under
                                this department.
                            </div>

                        @endif


                    </div>


                </div>


            @endforeach


        </div>



        {{-- =====================================================
             LOWER INFORMATION
        ====================================================== --}}

        <div class="erp-lower-grid">


            {{-- Recent Applications --}}

            <div class="erp-lower-panel">


                <div class="erp-lower-header">

                    <h3>
                        Recent Applications
                    </h3>

                    <span>
                        Latest 8
                    </span>

                </div>


                <div class="erp-recent-list">


                    @forelse($recentApplications as $application)

                        @php
                            $status =
                                strtolower(
                                    $application->status
                                    ??
                                    'draft'
                                );

                            $statusClass =
                                match($status) {

                                    'submitted' =>
                                        'erp-badge-submitted',

                                    'approved' =>
                                        'erp-badge-approved',

                                    'rejected' =>
                                        'erp-badge-rejected',

                                    default =>
                                        'erp-badge-draft',
                                };
                        @endphp


                        <div class="erp-recent-item">


                            <div class="erp-recent-main">

                                <div class="erp-recent-name">

                                    {{
                                        $application->student_name
                                        ??
                                        $application->name
                                        ??
                                        'Student Application'
                                    }}

                                </div>


                                <div class="erp-recent-course">

                                    {{
                                        $application
                                            ->course
                                            ?->name
                                            ??
                                            'Course not selected'
                                    }}

                                </div>

                            </div>


                            <span
                                class="
                                    erp-status-badge
                                    {{ $statusClass }}
                                "
                            >
                                {{ ucfirst($status) }}
                            </span>


                        </div>


                    @empty


                        <div class="erp-empty">
                            No applications found.
                        </div>


                    @endforelse


                </div>


            </div>



            {{-- Application Snapshot --}}

            <div class="erp-lower-panel">


                <div class="erp-lower-header">

                    <h3>
                        Application Snapshot
                    </h3>

                    <span>
                        Overall
                    </span>

                </div>


                <div class="erp-snapshot">


                    <div class="erp-snapshot-item">

                        <div class="erp-snapshot-top">

                            <span>
                                Pending Verification
                            </span>

                            <span>
                                {{ $pendingPercent }}%
                            </span>

                        </div>


                        <div class="erp-progress">

                            <div
                                class="
                                    erp-progress-fill
                                    erp-progress-pending
                                "
                                style="
                                    width:
                                    {{ min($pendingPercent, 100) }}%;
                                "
                            ></div>

                        </div>

                    </div>



                    <div class="erp-snapshot-item">

                        <div class="erp-snapshot-top">

                            <span>
                                Approved Applications
                            </span>

                            <span>
                                {{ $approvedPercent }}%
                            </span>

                        </div>


                        <div class="erp-progress">

                            <div
                                class="
                                    erp-progress-fill
                                    erp-progress-approved
                                "
                                style="
                                    width:
                                    {{ min($approvedPercent, 100) }}%;
                                "
                            ></div>

                        </div>

                    </div>



                    <div class="erp-snapshot-item">

                        <div class="erp-snapshot-top">

                            <span>
                                Rejected Applications
                            </span>

                            <span>
                                {{ $rejectedPercent }}%
                            </span>

                        </div>


                        <div class="erp-progress">

                            <div
                                class="
                                    erp-progress-fill
                                    erp-progress-rejected
                                "
                                style="
                                    width:
                                    {{ min($rejectedPercent, 100) }}%;
                                "
                            ></div>

                        </div>

                    </div>



                    <div class="erp-total-applications">

                        <span>
                            Total Applications
                        </span>

                        <strong>
                            {{ $totalApplications }}
                        </strong>

                    </div>


                </div>


            </div>


        </div>


    </div>

</div>



<script>
    /*
    |--------------------------------------------------------------------------
    | ERP Department Details
    |--------------------------------------------------------------------------
    |
    | One panel is open at a time.
    |
    | Same button:
    |   OPEN  -> CLOSE
    |
    | Other button:
    |   CLOSE OLD -> OPEN NEW
    |
    */


    function resetERPButtons() {

        document
            .querySelectorAll('.erp-detail-button')
            .forEach(function(button) {

                button.classList.remove('active');

                button.setAttribute(
                    'aria-expanded',
                    'false'
                );

                const text =
                    button.querySelector(
                        '.erp-detail-text'
                    );

                if (text) {
                    text.textContent =
                        'View Details';
                }

            });

    }



    function closeAllERPDetails() {

        document
            .querySelectorAll(
                '[data-erp-detail-panel="true"]'
            )
            .forEach(function(panel) {

                panel.classList.remove('open');

            });

        resetERPButtons();

    }



    function toggleERPDepartment(
        detailId,
        clickedButton
    ) {

        const detailPanel =
            document.getElementById(
                detailId
            );


        if (!detailPanel) {
            return;
        }


        const alreadyOpen =
            detailPanel.classList.contains(
                'open'
            );


        /*
        |--------------------------------------------------------------------------
        | Always close every department first.
        |--------------------------------------------------------------------------
        */

        closeAllERPDetails();


        /*
        |--------------------------------------------------------------------------
        | Same button was already open:
        | leave everything closed.
        |--------------------------------------------------------------------------
        */

        if (alreadyOpen) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Open the selected department.
        |--------------------------------------------------------------------------
        */

        detailPanel.classList.add(
            'open'
        );

        clickedButton.classList.add(
            'active'
        );

        clickedButton.setAttribute(
            'aria-expanded',
            'true'
        );


        const text =
            clickedButton.querySelector(
                '.erp-detail-text'
            );


        if (text) {
            text.textContent =
                'Hide Details';
        }


        /*
        |--------------------------------------------------------------------------
        | Scroll to detail panel.
        |--------------------------------------------------------------------------
        */

        setTimeout(function() {

            const panelTop =
                detailPanel
                    .getBoundingClientRect()
                    .top
                +
                window.pageYOffset
                -
                90;


            window.scrollTo({

                top: panelTop,

                behavior: 'smooth'

            });

        }, 70);

    }



    function closeERPDepartment(
        detailId
    ) {

        const panel =
            document.getElementById(
                detailId
            );


        if (panel) {

            panel.classList.remove(
                'open'
            );

        }


        resetERPButtons();

    }



    /*
    |--------------------------------------------------------------------------
    | ESC = close
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function(event) {

            if (
                event.key ===
                'Escape'
            ) {

                closeAllERPDetails();

            }

        }
    );

</script>


<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
(function () {
    function renderErpCharts() {
        if (typeof Chart === 'undefined') return;
        const deptLabels = @json($dashboardDepartments->pluck('name')->values());
        const studentValues = @json($dashboardDepartments->map(fn($d) => (int) ($d->dashboard_student_total ?? 0))->values());
        const appValues = @json($dashboardDepartments->map(fn($d) => (int) ($d->dashboard_application_total ?? 0))->values());
        const gridColor = 'rgba(148,163,184,.18)';
        const font = { family: 'Inter, Segoe UI, sans-serif' };
        const deptCanvas = document.getElementById('erpDepartmentChart');
        if (deptCanvas && !deptCanvas.dataset.ready) {
            new Chart(deptCanvas, {
                type: 'bar',
                data: { labels: deptLabels, datasets: [
                    { label: 'Students', data: studentValues, backgroundColor: 'rgba(99,102,241,.82)', borderRadius: 7, maxBarThickness: 28 },
                    { label: 'Applications', data: appValues, backgroundColor: 'rgba(20,184,166,.78)', borderRadius: 7, maxBarThickness: 28 }
                ]},
                options: { responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false }, plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8, padding: 18, font: font } }, tooltip: { backgroundColor: '#172033', padding: 12, cornerRadius: 10 } }, scales: { x: { grid: { display: false }, ticks: { color: '#7b879b', font: font, maxRotation: 35, minRotation: 0 } }, y: { beginAtZero: true, grid: { color: gridColor }, ticks: { precision: 0, color: '#7b879b', font: font } } } }
            });
            deptCanvas.dataset.ready = '1';
        }
        const appCanvas = document.getElementById('erpApplicationChart');
        if (appCanvas && !appCanvas.dataset.ready) {
            new Chart(appCanvas, {
                type: 'doughnut',
                data: { labels: ['Today', 'Pending verification', 'Approved', 'Other applications'], datasets: [{ data: [Math.max(0, Number(@json($todayApplications))), Math.max(0, Number(@json($submittedApplications))), Math.max(0, Number(@json($approvedApplications))), Math.max(0, Number(@json($totalApplications)) - Number(@json($todayApplications)) - Number(@json($submittedApplications)) - Number(@json($approvedApplications)))], backgroundColor: ['#8b7cf6','#f5b94c','#20b486','#dce2ed'], borderWidth: 0, hoverOffset: 5 }] },
                options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8, padding: 13, font: font } }, tooltip: { backgroundColor: '#172033', padding: 12, cornerRadius: 10 } } }
            });
            appCanvas.dataset.ready = '1';
        }
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', renderErpCharts); else renderErpCharts();
})();
</script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Chart === 'undefined') return;

    const trendCanvas = document.getElementById('admissionsTrendChart');
    if (trendCanvas) {
        new Chart(trendCanvas, {
            type: 'line',
            data: {
                labels: @json($admissionsTrendLabels ?? []),
                datasets: [{
                    label: 'Applications',
                    data: @json($admissionsTrendData ?? []),
                    borderColor: '#6852e8',
                    backgroundColor: 'rgba(104,82,232,.12)',
                    fill: true,
                    tension: .38,
                    borderWidth: 3,
                    pointRadius: 3,
                    pointHoverRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#eef0f6' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    const courseCanvas = document.getElementById('courseStrengthChart');
    if (courseCanvas) {
        new Chart(courseCanvas, {
            type: 'bar',
            data: {
                labels: @json($courseChartLabels ?? []),
                datasets: [{
                    label: 'Active students',
                    data: @json($courseChartData ?? []),
                    backgroundColor: '#8270f0',
                    hoverBackgroundColor: '#5145cd',
                    borderRadius: 6,
                    maxBarThickness: 32
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#eef0f6' } },
                    y: { grid: { display: false } }
                }
            }
        });
    }
});
</script>

@endsection
