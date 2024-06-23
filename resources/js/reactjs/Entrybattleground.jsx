import React from "react";
import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import Battleground from "./components/Battleground";

const rootRender = createRoot(
    document.getElementById("entry_battleground")
).render(
    <StrictMode>
        <Battleground />
    </StrictMode>
);
