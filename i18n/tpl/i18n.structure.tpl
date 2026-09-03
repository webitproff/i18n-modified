<!--
	/********************************************************************************
	* File: i18n.structure.tpl
	* Extension: plugin 'i18n'
	* Description: HTML template for i18n plugin.
	* Compatibility: CMF/CMS Cotonti Siena v0.9.26[](https://github.com/Cotonti/Cotonti)
	* Dependencies: 
	* 		 Bootstrap 5.3.+[](https://getbootstrap.com/); 
	* 		 Font Awesome Free 7.1[](https://fontawesome.com/)
	* Theme: Index36  
	* Version: 1.0.2 
	* Created: 01 Feb 2026 
	* Updated: 23 Feb 2026 
	* Copyright (c) 2026 webitproff | https://github.com/webitproff
	* Source: https://github.com/webitproff/index36-cotonti-theme
	* Demo : https://freelance-script.abuyfile.com/ 
	* Help and support: https://abuyfile.com/ru/forums/cotonti/original/skins/index36
	* License: BSD (Free distribution with saving Copyright (c) 2026 webitproff)  
	********************************************************************************/
-->
<!-- BEGIN: MAIN -->
<div id="ajaxBlock">
	<div class="container py-5 min-height-50vh">
        {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
		
        <h2 class="mb-5 fw-bold text-center text-md-start">
            <i class="fa-solid fa-sitemap me-3 text-primary"></i>{PHP.L.i18n_structure}
		</h2>
		
        <div class="row justify-content-center mb-5">
            <div class="col-12 col-lg-10">
                <div class="row g-0 shadow-sm rounded overflow-hidden">
                    <div class="col-12 col-md-6">
                        <div class="p-4 bg-success text-white fw-bold text-center text-md-start">
                            {I18N_ORIGINAL_LANG}
						</div>
					</div>
                    <div class="col-12 col-md-6">
                        <div class="p-4 bg-warning text-dark fw-bold text-center text-md-start">
                            {I18N_TARGET_LANG}
						</div>
					</div>
				</div>
			</div>
		</div>
		
        <form action="{I18N_ACTION}" method="post">
			
            <!-- BEGIN: I18N_CATEGORY_ROW -->
            <div class="card border-0 shadow-sm mb-5 rounded-3 overflow-hidden">
                <div class="card-body p-0">
                    <div class="row g-0">
						
                        <div class="col-12 col-md-6 bg-success-subtle p-4 p-md-5">
                            <h4 class="card-title fw-bold mb-3 text-success-emphasis">
                                {I18N_CATEGORY_ROW_TITLE}
							</h4>
                            <p class="text-muted fst-italic mb-0">
                                <em>{I18N_CATEGORY_ROW_DESC}</em>
							</p>
                            <input type="hidden" name="{I18N_CATEGORY_ROW_CODE_NAME}" value="{I18N_CATEGORY_ROW_CODE_VALUE}" />
						</div>
						
                        <div class="col-12 col-md-6 bg-warning-subtle p-4 p-md-5">
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-warning-emphasis">
                                    {PHP.L.Title}
								</label>
                                <input type="text" class="form-control form-control-lg" 
								name="{I18N_CATEGORY_ROW_ITITLE_NAME}" 
								value="{I18N_CATEGORY_ROW_ITITLE_VALUE}" 
								maxlength="128" />
							</div>
							
                            <div class="mb-0">
                                <label class="form-label fw-semibold text-warning-emphasis">
                                    {PHP.L.Description}
								</label>
                                <textarea class="form-control form-control-lg" 
								name="{I18N_CATEGORY_ROW_IDESC_NAME}" 
								rows="5">{I18N_CATEGORY_ROW_IDESC_VALUE}</textarea>
							</div>
						</div>
						
					</div>
				</div>
			</div>
            <!-- END: I18N_CATEGORY_ROW -->
			
            <div class="text-center mt-5 pt-4">
                <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                    <i class="fa-solid fa-floppy-disk me-2"></i>{PHP.L.Update}
				</button>
			</div>
			
		</form>
		
        <nav aria-label="Pagination" class="mt-5">
            <ul class="pagination pagination-lg justify-content-center">
                {I18N_PAGINATION_PREV}{I18N_PAGNAV}{I18N_PAGINATION_NEXT}
			</ul>
		</nav>
		
	</div>
	
	
</div>
<!-- END: MAIN -->