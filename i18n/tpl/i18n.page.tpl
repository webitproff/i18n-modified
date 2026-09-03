<!--
	/********************************************************************************
	* File: i18n.page.tpl
	* Extension: plugin 'i18n'
	* Description: HTML template for i18n plugin.
	* Compatibility: CMF/CMS Cotonti Siena v0.9.26[](https://github.com/Cotonti/Cotonti)
	* Dependencies: 
	* 		 Bootstrap 5.3.+[](https://getbootstrap.com/); 
	* 		 Font Awesome Free 7.1[](https://fontawesome.com/)
	* Theme: Index36  
	* Version: 1.0.2 
	* Created: 01 Feb 2026 
	* Updated: 09 March 2026 
	* Copyright (c) 2026 webitproff | https://github.com/webitproff
	* Source: https://github.com/webitproff/index36-cotonti-theme
	* Demo : https://freelance-script.abuyfile.com/ 
	* Help and support: https://abuyfile.com/ru/forums/cotonti/original/skins/index36
	* License: BSD (Free distribution with saving Copyright (c) 2026 webitproff)  
	********************************************************************************/
-->
<!-- BEGIN: MAIN -->
<div class="border-bottom border-secondary py-3 px-3">
    <nav aria-label="breadcrumb">
        <div class="ps-container-breadcrumb">
            <ol class="breadcrumb d-flex mb-0 align-items-center">
                <i class="fa-solid fa-language me-3 fs-4 text-primary"></i>
                <li class="breadcrumb-item active fw-bold">{I18N_TITLE}</li>
			</ol>
		</div>
	</nav>
</div>
<div class="py-4 px-3 px-md-4 min-height-50vh">
    <h2 class="mb-4 fw-bold text-center text-md-start">{I18N_TITLE}</h2>
    {FILE "{PHP.cfg.themes_dir}/{PHP.usr.theme}/warnings.tpl"}
    <form action="{I18N_ACTION}" method="post" class="needs-validation" novalidate>
        <div class="row mb-5">
            <div class="col-12">
                <div class="row g-0 align-items-stretch">
					<div class="p-3 mb-0 mb-md-0 bg-success text-white rounded-3 fw-bold text-center text-md-start h-100 d-flex align-items-center justify-content-center justify-content-md-start">
						{PHP.L.i18n_original} ({I18N_ORIGINAL_LANG})
					</div>
				</div>
			</div>
		</div>
        <div class="card border-0 mb-5 shadow-sm rounded-0">
            <div class="card-body p-0">
                <div class="row g-0">
                    <!-- Оригинал (левая колонка) -->
                    <div class="col-12 col-md-6 bg-success-subtle p-3 p-md-5">
                        <p class="fw-semibold mb-2">{PHP.L.Title}</p>
                        <div class="mb-4 border rounded border-secondary-subtle p-3 bg-white">
                            <span class="fw-semibold">{I18N_PAGE_TITLE}</span>
						</div>
                        <p class="fw-semibold mb-2">{PHP.L.Description}</p>
                        <div class="mb-4 border rounded border-secondary-subtle p-3 bg-white">
                            {I18N_PAGE_DESC}
						</div>				
                        <!-- IF {I18N_IPAGE_TAGS} -->
                        <p class="fw-semibold mb-2">{PHP.L.Tags}</p>
                        <div class="mb-4 border rounded border-secondary-subtle p-3 bg-white">
                            {I18N_PAGE_TAGS}
						</div>
                        <!-- ENDIF -->				
                        <p class="fw-semibold mb-2">{PHP.L.Text}</p>
                        <div class="border rounded border-secondary-subtle p-3 bg-white" style="min-height: 300px; overflow-y: auto;">
                            {I18N_PAGE_TEXT}
						</div>
					</div>	
                    <!-- Локализация (правая колонка) -->
                    <div class="col-12 col-md-6 bg-warning-subtle p-3 p-md-5">
						<h3 class="text-danger text-center">{PHP.L.i18n_localized}</h3>
                        <div class="py-2">
                            <label class="form-label fw-semibold">{PHP.L.Title}</label>
                            <input type="text" class="form-control form-control-lg" name="title"
							value="{I18N_IPAGE_TITLE}" maxlength="128" required />
						</div>
                        <div class="py-2">
                            <label class="form-label fw-semibold">{PHP.L.Description}</label>
                            <textarea class="form-control form-control-lg" name="desc" rows="5" maxlength="255">{I18N_IPAGE_DESC}</textarea>
						</div>		
						
						<!-- ===== БЛОК ДОПОЛНИТЕЛЬНЫХ ПОЛЕЙ (EXTRAFIELDS) ===== -->
						<!-- Каждое поле выводится в цикле через блок EXTRAFLD -->
						<!-- BEGIN: EXTRAFLD -->
						<div class="py-2">
							<label class="form-label fw-semibold">{I18N_PAGE_FORM_EXTRAFLD_TITLE}</label>
							{I18N_PAGE_FORM_EXTRAFLD}
						</div>
						<!-- END: EXTRAFLD -->
						<!-- ===== КОНЕЦ БЛОКА EXTRAFIELDS ===== -->
						
                        <!-- BEGIN: TAGS -->
                        <div class="py-2">
                            <label class="form-label fw-semibold">{PHP.L.Tags}</label>
                            {I18N_IPAGE_TAGS}
                            <small class="form-text text-muted d-block mt-1">({PHP.L.tags_comma_separated})</small>
						</div>
                        <!-- END: TAGS -->			
                        <div class="py-2">
                            <label class="form-label fw-semibold">{PHP.L.Text}</label>
							
                            <div class="form-floating">
                                {I18N_IPAGE_TEXT}
							</div>
						</div>
                        <div class="p-3 mb-0 bg-warning text-dark ">
                            <div class="row g-0 w-100">
                                <div class="col-12 col-md-6">{PHP.L.i18n_locale_selection}</div>
                                <div class="col-12 col-md-6">{I18N_LOCALIZED_LANG}</div>
							</div>
						</div>						
                        <div class="col-12 text-center py-5 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                                <i class="fa-solid fa-floppy-disk me-2"></i>{PHP.L.Submit}
							</button>
						</div>		
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- END: MAIN -->