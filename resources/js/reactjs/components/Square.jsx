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
                // console.log(response);
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
                    width="360"
                    height="360"
                    viewBox="0 0 360 360"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <rect
                        x="63.4975"
                        y="346.34"
                        width="70"
                        height="400"
                        rx="5"
                        transform="rotate(-135 63.4975 346.34)"
                        fill="#8B322C"
                    />
                    <rect
                        x="14"
                        y="63.4975"
                        width="70"
                        height="400"
                        rx="5"
                        transform="rotate(-45 14 63.4975)"
                        fill="#8B322C"
                    />
                </svg>
            ) : value == "O" ? (
                <svg
                    className="size-4 laptop:size-8"
                    width="360"
                    height="360"
                    viewBox="0 0 360 360"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <circle
                        cx="180"
                        cy="180"
                        r="125"
                        stroke="#FEFFD2"
                        strokeWidth="70"
                    />
                </svg>
            ) : (
                ""
            )}
        </button>
    );
}
