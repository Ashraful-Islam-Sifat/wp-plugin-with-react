import React from "react";
import { createRoot } from 'react-dom/client';
import App from "./App";

document.addEventListener("DOMContentLoaded", function () {
    var element = document.getElementById("new-dashboard-widget");
    if (typeof element !== "undefined" && element !== null) {
        const root = createRoot(element);
        root.render(<App />);
    }
});
