<template>
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
</template>

<style>
*, *::before, *::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

:root {
  --bg-base:       #ffffff;
  --bg-surface:    #f8fafc;
  --bg-card:       #ffffff;
  --border:        #e2e8f0;
  --border-accent: #bfdbfe;
  --blue:          #2563eb;
  --blue-dark:     #1e3a8a;
  --blue-light:    #eff6ff;
  --text:          #0f172a;
  --text-muted:    #64748b;
  --text-dim:      #94a3b8;
}

html, body {
  min-height: 100%;
  background: var(--bg-base);
  color: var(--text);
  font-family: 'DM Sans', -apple-system, sans-serif;
  -webkit-font-smoothing: antialiased;
}

.font-display {
  font-family: 'Outfit', sans-serif;
}

/* Kékes gradiens a headline akcentusokhoz */
.gradient-text {
  background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

/* Kártya alapstílus */
.glass-card {
  background: #ffffff;
  border: 1px solid var(--border);
  border-radius: 16px;
  transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
}

.glass-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 32px rgba(37, 99, 235, 0.1);
  border-color: var(--border-accent);
}

/* Elsődleges gomb */
.btn-primary {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: #2563eb;
  color: #fff;
  font-weight: 600;
  padding: 12px 26px;
  border-radius: 12px;
  text-decoration: none;
  transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
  border: none;
  cursor: pointer;
  font-family: 'DM Sans', sans-serif;
  font-size: 0.9rem;
}

.btn-primary:hover {
  background: #1d4ed8;
  transform: translateY(-1px);
  box-shadow: 0 4px 16px rgba(37, 99, 235, 0.35);
}

/* Ghost gomb */
.btn-ghost {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: rgba(255, 255, 255, 0.1);
  color: #fff;
  font-weight: 600;
  padding: 12px 26px;
  border-radius: 12px;
  text-decoration: none;
  transition: background 0.2s;
  border: 1px solid rgba(255, 255, 255, 0.25);
  cursor: pointer;
  font-family: 'DM Sans', sans-serif;
  font-size: 0.9rem;
}

.btn-ghost:hover {
  background: rgba(255, 255, 255, 0.18);
}

/* Szekció badge */
.section-label {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: #eff6ff;
  border: 1px solid #bfdbfe;
  color: #1d4ed8;
  font-size: 0.75rem;
  font-weight: 600;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  padding: 6px 14px;
  border-radius: 100px;
}
</style>
