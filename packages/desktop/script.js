const { app, BrowserWindow } = require('electron');

const createWindow = () => {
    const win = new BrowserWindow({
        width: 800,
        height: 600
    });

    win.loadFile('vendor/base-php/core/packages/desktop/index.html');
}

app.whenReady().then(() => {
    createWindow();
});