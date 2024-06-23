import React from "react";

const battleground_id = document
    .getElementById("entry_battleground")
    .getAttribute("battleground_id");

const fighter_id = document.body.getAttribute("fighter_id");

export default function Square({ value, position, play, setPlay }) {
    async function handleFighting(position) {
        setPlay(false);
        const res = await axios
            .post("/api/battleground/" + battleground_id, {
                position: position,
            })
            .then(function (response) {
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    return (
        <button
            className={
                "rounded-primative flex items-center justify-center bg-gray p-1 size-4 laptop:size-8 " +
                (!(value || !play) ? " hover:animate-spin" : "")
            }
            onClick={() => handleFighting(position)}
            disabled={value || !play}
        >
            {value == "X" ? (
                <svg
                    className="size-4 laptop:size-8"
                    viewBox="0 0 360 360"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <rect
                        x="49.2132"
                        y="332.056"
                        width="30"
                        height="400"
                        rx="5"
                        transform="rotate(-135 49.2132 332.056)"
                        fill="#8B322C"
                    />
                    <rect
                        x="28"
                        y="49.2132"
                        width="30"
                        height="400"
                        rx="5"
                        transform="rotate(-45 28 49.2132)"
                        fill="#8B322C"
                    />
                </svg>
            ) : value == "O" ? (
                <svg
                    className="size-4 laptop:size-8"
                    viewBox="0 0 360 360"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <circle
                        cx="180"
                        cy="180"
                        r="110"
                        stroke="#FFE8B5"
                        strokeWidth="30"
                    />
                </svg>
            ) : (
                ""
            )}
        </button>
    );
}
