// ======================
// Global Configuration
// ======================
const API_BASE = '/api/';
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
const commonHeaders = {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': CSRF_TOKEN
};

// ======================
// Authentication Management
// ======================
async function checkAuthState() {
    try {
        const response = await fetch(`${API_BASE}check-auth.php`);
        if (!response.ok) throw new Error('Network response error');
        
        const data = await response.json();
        updateNavigation(data.loggedIn);
        return data.loggedIn;
    } catch (error) {
        showNotification('Error checking authentication status', 'error');
        return false;
    }
}

function updateNavigation(isLoggedIn) {
    const authLinks = document.getElementById('authLinks');
    if (!authLinks) return;

    authLinks.innerHTML = isLoggedIn ? `
        <a href="dashboard.php" class="nav-link">
            <i class="fas fa-chart-line"></i> Dashboard
        </a>
        <a href="logout.php" class="nav-link btn-logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    ` : `
        <a href="login.php" class="nav-link btn-login">
            <i class="fas fa-sign-in-alt"></i> Login
        </a>
        <a href="register.php" class="nav-link">
            <i class="fas fa-user-plus"></i> Register
        </a>
    `;
}

// ======================
// Watchlist Management
// ======================
async function addToWatchlist(symbol) {
    try {
        showLoader(true);
        const response = await fetch(`${API_BASE}watchlist.php`, {
            method: 'POST',
            headers: commonHeaders,
            body: JSON.stringify({ symbol: symbol.toUpperCase() })
        });

        const result = await response.json();
        if (!response.ok) throw new Error(result.error || 'Failed to add to watchlist');

        showNotification(`Added ${symbol} to watchlist!`, 'success');
        return true;
    } catch (error) {
        showNotification(error.message, 'error');
        return false;
    } finally {
        showLoader(false);
    }
}

async function removeFromWatchlist(symbol) {
    try {
        showLoader(true);
        const response = await fetch(`${API_BASE}watchlist.php`, {
            method: 'DELETE',
            headers: commonHeaders,
            body: JSON.stringify({ symbol: symbol.toUpperCase() })
        });

        const result = await response.json();
        if (!response.ok) throw new Error(result.error || 'Failed to remove from watchlist');

        showNotification(`Removed ${symbol} from watchlist`, 'success');
        return true;
    } catch (error) {
        showNotification(error.message, 'error');
        return false;
    } finally {
        showLoader(false);
    }
}

// ======================
// UI Helpers
// ======================
function showNotification(message, type = 'info') {
    const container = document.getElementById('notifications') || createNotificationContainer();
    const notification = document.createElement('div');
    
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <span class="icon">${getIcon(type)}</span>
        <span>${message}</span>
        <button class="close-btn">&times;</button>
    `;

    notification.querySelector('.close-btn').addEventListener('click', () => {
        notification.remove();
    });

    container.appendChild(notification);
    setTimeout(() => notification.remove(), 5000);
}

function createNotificationContainer() {
    const container = document.createElement('div');
    container.id = 'notifications';
    document.body.prepend(container);
    return container;
}

function getIcon(type) {
    const icons = {
        success: '✓',
        error: '⚠️',
        info: 'ℹ️'
    };
    return icons[type] || '';
}

function showLoader(show) {
    const loader = document.getElementById('global-loader') || createGlobalLoader();
    loader.style.display = show ? 'block' : 'none';
}

function createGlobalLoader() {
    const loader = document.createElement('div');
    loader.id = 'global-loader';
    loader.className = 'global-loader';
    document.body.appendChild(loader);
    return loader;
}

// ======================
// Event Listeners
// ======================
document.addEventListener('DOMContentLoaded', () => {
    // Initialize auth state
    checkAuthState();
    
    // Global click handler for watchlist actions
    document.body.addEventListener('click', async (e) => {
        if (e.target.closest('.add-to-watchlist')) {
            const symbol = e.target.dataset.symbol;
            const success = await addToWatchlist(symbol);
            if (success) {
                const card = e.target.closest('.stock-card');
                card?.querySelector('.add-to-watchlist')?.replaceWith(createRemoveButton(symbol));
            }
        }
        
        if (e.target.closest('.remove-from-watchlist')) {
            const symbol = e.target.dataset.symbol;
            const success = await removeFromWatchlist(symbol);
            if (success) {
                e.target.closest('.stock-card')?.remove();
            }
        }
    });
});

// ======================
// Helper Functions
// ======================
function createRemoveButton(symbol) {
    const button = document.createElement('button');
    button.className = 'btn btn-danger btn-sm remove-from-watchlist';
    button.innerHTML = '<i class="fas fa-trash"></i> Remove';
    button.dataset.symbol = symbol;
    return button;
}

// ======================
// Stock Data Utilities
// ======================
async function fetchStockData(symbol) {
    try {
        const response = await fetch(`${API_BASE}stock-data.php?symbol=${symbol}`);
        if (!response.ok) throw new Error('Network response error');
        
        const data = await response.json();
        if (data.error) throw new Error(data.error);
        
        return data;
    } catch (error) {
        showNotification(`Failed to fetch data for ${symbol}`, 'error');
        return null;
    }
}

function updateStockCard(cardElement, stockData) {
    if (!cardElement || !stockData) return;

    cardElement.querySelector('.stock-price').textContent = `$${stockData.price}`;
    cardElement.querySelector('.stock-change').innerHTML = `
        <span class="${stockData.change >= 0 ? 'positive' : 'negative'}">
            ${stockData.change} (${stockData.changePercent}%)
        </span>
    `;
}