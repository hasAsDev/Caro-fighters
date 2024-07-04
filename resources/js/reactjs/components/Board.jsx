import React, { useState } from "react";
import Square from "./Square";

export default function Board({ battle_record, play, setPlay }) {
    return (
        <div className="w-fit grid grid-cols-15 bg-[#191919] rounded-primative gap-[0.5px] tablet:gap-0.5 p-1">
            {battle_record.map((rows, row_index) => {
                return rows.map((cell, col_index) => {
                    const position = row_index * 15 + col_index;
                    return (
                        <Square
                            key={position}
                            position={position}
                            value={cell}
                            play={play}
                            setPlay={setPlay}
                        />
                    );
                });
            })}
        </div>
    );
}
