<x-filament-widgets::widget class="fi-account-widget">
    <div class="fi-section overflow-hidden rounded-xl shadow-lg ring-1 ring-gray-950/5 dark:ring-white/10"
         style="padding: 0; margin: 0;">
        
        <div class="relative overflow-hidden rounded-xl" 
             style="
                background: linear-gradient(90deg, #EA580C 0%, #C2410C 100%); 
                padding: 2.5rem 3rem; 
                display: flex; 
                flex-direction: row; 
                align-items: center; 
                justify-content: space-between; 
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                color: white;
                min-height: 160px;
             ">
            
            <div style="position: absolute; right: 0; top: 0; height: 100%; width: 40%; background: linear-gradient(to left, rgba(255,255,255,0.1), transparent); pointer-events: none;"></div>
            <div style="position: absolute; bottom: -50px; left: -20px; width: 200px; height: 200px; background: rgba(253, 224, 71, 0.15); border-radius: 50%; filter: blur(60px); pointer-events: none;"></div>

            <div style="display: flex; align-items: center; gap: 24px; position: relative; z-index: 10;">
                
                <div class="shrink-0 hidden md:block">
                    <x-filament-panels::avatar.user 
                        size="h-24 w-24" 
                        :user="filament()->auth()->user()" 
                        class="shadow-xl rounded-full"
                        style="border: 4px solid rgba(255,255,255,0.3); width: 80px; height: 80px;"
                    />
                </div>
                
                <div>
                    <div style="margin-bottom: 8px;">
                         <span style="
                            background: rgba(255,255,255,0.2); 
                            border: 1px solid rgba(255,255,255,0.2);
                            padding: 4px 12px; 
                            border-radius: 20px; 
                            font-size: 0.75rem; 
                            font-weight: 800; 
                            text-transform: uppercase; 
                            letter-spacing: 1px;
                        ">
                            Administrator
                        </span>
                    </div>

                    <h2 style="font-size: 2rem; font-weight: 800; line-height: 1.1; text-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 0;">
                        Selamat Datang, <br>
                        {{ filament()->auth()->user()->name }}
                    </h2>
                    
                    <p style="opacity: 0.9; margin-top: 6px; font-size: 1rem; font-weight: 500;">
                        Sistem Informasi Cuti Pegawai
                    </p>
                </div>
            </div>

            <div style="text-align: right; position: relative; z-index: 10; padding-left: 2rem; border-left: 1px solid rgba(255,255,255,0.2);">
                
                <div style="text-transform: uppercase; letter-spacing: 1px; font-size: 0.85rem; font-weight: 700; color: #fed7aa; margin-bottom: 4px;">
                    {{ now()->locale('id')->translatedFormat('l, d F Y') }}
                </div>

                <div x-data="{ time: new Date() }" 
                     x-init="setInterval(() => time = new Date(), 1000)" 
                     style="line-height: 1; margin-top: 5px;">
                    
                    <span x-text="time.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }).replace('.', ':')" 
                          style="font-size: 3.5rem; font-weight: 800; letter-spacing: -2px; font-variant-numeric: tabular-nums;">
                        {{ now()->format('H:i') }}
                    </span>
                    <span style="font-size: 1rem; font-weight: 700; color: #fed7aa; display: block;">WIB</span>
                </div>
            </div>

        </div>
    </div>
</x-filament-widgets::widget>