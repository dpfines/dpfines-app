// Dashboard interaction JS extracted from blade
(function(){
    function initExpandable(section){
        const toggle = section.querySelector('.expand-toggle');
        const body = section.querySelector('.expandable-body');
        if(!toggle || !body) return;
        const expanded = toggle.getAttribute('aria-expanded') === 'true';
        const icon = toggle.querySelector('i');
        if(icon){
            if(expanded){ icon.classList.remove('fa-chevron-down'); icon.classList.add('fa-chevron-up'); toggle.setAttribute('aria-label','Collapse section'); }
            else { icon.classList.remove('fa-chevron-up'); icon.classList.add('fa-chevron-down'); toggle.setAttribute('aria-label','Expand section'); }
        }
        if(expanded){ body.style.maxHeight = body.scrollHeight + 'px'; }
        else { body.classList.add('collapsed'); body.style.maxHeight = '0px'; }
        toggle.addEventListener('click', function(){
            const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
            const ic = toggle.querySelector('i');
            if(isExpanded){
                body.style.maxHeight = body.scrollHeight + 'px';
                requestAnimationFrame(function(){ body.style.maxHeight = '0px'; body.classList.add('collapsed'); });
                toggle.setAttribute('aria-expanded','false');
                toggle.setAttribute('aria-label','Expand section');
                if(ic){ ic.classList.remove('fa-chevron-up'); ic.classList.add('fa-chevron-down'); }
            } else {
                body.classList.remove('collapsed');
                body.style.maxHeight = body.scrollHeight + 'px';
                toggle.setAttribute('aria-expanded','true');
                toggle.setAttribute('aria-label','Collapse section');
                if(ic){ ic.classList.remove('fa-chevron-down'); ic.classList.add('fa-chevron-up'); }
            }
        });
        window.addEventListener('resize', function(){ if(toggle.getAttribute('aria-expanded')==='true'){ body.style.maxHeight = body.scrollHeight + 'px'; } });
    }

    function applySharedLimit(selectId){
        const sel = document.getElementById(selectId);
        if(!sel) return;
        function applyLimit(){
            const val = sel.value;
            const n = val === 'all' ? Infinity : parseInt(val,10);
            const showHide = (containerId) => {
                const items = document.querySelectorAll('#' + containerId + ' .bar-item-extended');
                items.forEach((el, idx) => { el.style.display = (idx < n) ? 'block' : 'none'; });
            };
            showHide('sectors-list');
            showHide('violations-list');
        }
        sel.addEventListener('change', applyLimit);
        applyLimit();
    }

    async function exportAllSections(btnId){
        const exportBtn = document.getElementById(btnId);
        if(!exportBtn || !window.html2canvas || !window.JSZip) return;
        exportBtn.addEventListener('click', async function(){
            exportBtn.disabled = true; exportBtn.innerText = 'Preparing...';
            const sections = Array.from(document.querySelectorAll('section.dashboard-section'));
            const zip = new JSZip();
            for (let sec of sections) {
                try {
                    const prevStyle = sec.style.display;
                    sec.style.display = '';
                    const titleEl = sec.querySelector('h2, h3');
                    const name = (titleEl && titleEl.innerText) ? titleEl.innerText.replace(/[^a-z0-9-]+/gi,'_').toLowerCase() : (sec.id || 'section');
                    const canvas = await html2canvas(sec, { scale: 2, useCORS: true });
                    const blob = await new Promise(res => canvas.toBlob(res, 'image/png'));
                    zip.file(name + '.png', blob);
                    sec.style.display = prevStyle;
                } catch (err) { console.error('capture failed for', sec, err); }
            }
            try {
                const content = await zip.generateAsync({ type: 'blob' });
                saveAs(content, 'dashboard_sections.zip');
            } catch (err) { console.error('zip failed', err); alert('Export failed'); }
            exportBtn.disabled = false; exportBtn.innerText = 'Export All Sections as Images (ZIP)';
        });
    }

    // Export a single section as PNG using html2canvas
    function initSectionDownloads(){
        if(!window.html2canvas || !window.saveAs) return;
        document.querySelectorAll('.section-download').forEach(function(btn){
            btn.addEventListener('click', async function(e){
                e.preventDefault();
                const targetSel = btn.getAttribute('data-target');
                let targetEl = null;
                if(targetSel){ targetEl = document.querySelector(targetSel); }
                if(!targetEl){ targetEl = btn.closest('section.dashboard-section'); }
                if(!targetEl) return;
                const prevText = btn.innerHTML;
                try {
                    btn.disabled = true; btn.classList.add('loading');
                    // pick title for filename
                    const titleEl = targetEl.querySelector('h2, h3');
                    const raw = titleEl ? titleEl.innerText.trim() : (targetEl.id || 'dashboard_section');
                    const safeName = raw.replace(/[^a-z0-9-_]+/gi,'_').toLowerCase();
                    const canvas = await html2canvas(targetEl, { scale: 2, useCORS: true });
                    const blob = await new Promise(res => canvas.toBlob(res, 'image/png'));
                    saveAs(blob, safeName + '.png');
                } catch(err){ console.error('single section export failed', err); alert('Export failed'); }
                finally { btn.disabled = false; btn.classList.remove('loading'); btn.innerHTML = prevText; }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function(){
        document.querySelectorAll('section.expandable').forEach(initExpandable);
        applySharedLimit('shared-limit-select');
        exportAllSections('export-all-sections');
        initSectionDownloads();
            // apply data-fill -> CSS width for bar-fill elements to avoid inline style interpolation in blade
            document.querySelectorAll('.bar-fill').forEach(function(el){
                const df = el.getAttribute('data-fill');
                if(df !== null){
                    // set CSS custom property and explicit width for broad compatibility
                    try { el.style.setProperty('--fill', df + '%'); } catch(e){}
                    el.style.width = (parseFloat(df) || 0) + '%';
                }
            });
            // initialize XLSX export button if SheetJS is available
            if(window.XLSX){ exportXLSX('export-xlsx'); }
    });

    // XLSX export: use window.__dashboardData (set from server-side blade) and SheetJS (XLSX)
    function exportXLSX(btnId){
        const btn = document.getElementById(btnId);
        if(!btn || !window.XLSX || !window.__dashboardData) return;
        btn.addEventListener('click', function(){
            btn.disabled = true; btn.innerText = 'Preparing XLSX...';
            try {
                const wb = XLSX.utils.book_new();
                const data = window.__dashboardData || {};
                // Helper to convert array-of-objects to worksheet
                const addSheet = (name, rows) => {
                    if(!rows || !rows.length) return;
                    const ws = XLSX.utils.json_to_sheet(rows);
                    XLSX.utils.book_append_sheet(wb, ws, name.slice(0,31));
                };
                addSheet('Regulators', data.regulators || []);
                addSheet('Sectors', data.sectors || []);
                addSheet('Violations', data.violations || []);
                addSheet('By Year', data.yearly || []);
                addSheet('Regions', data.regions || []);
                addSheet('Top Organizations', data.organizations || []);
                addSheet('Largest Fines', data.largest || []);
                const wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });
                function s2ab(s){
                    const buf = new ArrayBuffer(s.length);
                    const view = new Uint8Array(buf);
                    for (let i=0; i<s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
                    return buf;
                }
                saveAs(new Blob([s2ab(wbout)], {type: 'application/octet-stream'}), 'dashboard_data.xlsx');
            } catch(err){ console.error('XLSX export failed', err); alert('Export failed'); }
            btn.disabled = false; btn.innerText = 'Export XLSX';
        });
    }

})();
