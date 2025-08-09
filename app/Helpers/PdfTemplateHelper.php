<?php
// Helper for PDF generation with FPDI
namespace App\Helpers;

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;

class PdfTemplateHelper
{
    /**
     * Generate a PDF for each original document using a template, overlaying QR and info box.
     * @param array $originals Array of file paths to original documents (PDFs)
     * @param string $template Path to template PDF
     * @param string $qrPath Path to QR code image
     * @param array $infoBox ['name' => ..., 'email' => ..., 'phone' => ...]
     * @return string Path to generated PDF
     */
    public static function generateWithTemplate($originals, $template, $qrPath, $infoBox)
    {
        $output = storage_path('app/public/attested/attested_' . uniqid() . '.pdf');
        $pdf = new Fpdi();
        foreach ($originals as $original) {
            $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
            $templatePageCount = $pdf->setSourceFile($template);
            if ($ext === 'pdf') {
                $originalPageCount = $pdf->setSourceFile($original);
                for ($pageNo = 1; $pageNo <= $originalPageCount; $pageNo++) {
                    // Import template as background
                    $tplIdx = $pdf->importPage(1); // Always use first page of template
                    $pdf->AddPage();
                    $pdf->useTemplate($tplIdx, 0, 0, 210, 297); // A4 size
                    // Import original document page into the main content area (centered, scaled)
                    $origIdx = $pdf->importPage($pageNo);
                    $marginTop = 0; $marginLeft = 20; $contentW = 170; $contentH = 180; // No top margin
                    $pdf->useTemplate($origIdx, $marginLeft, $marginTop, $contentW, $contentH);
                    // Draw info box and QR code at bottom as in screenshot
                    $boxW = 120; $boxH = 28; $qrSize = 22;
                    $boxX = 210 - $boxW - $qrSize - 12; // leave space for QR
                    $boxY = 297 - $boxH - 12;
                    $qrX = 210 - $qrSize - 8;
                    $qrY = 297 - $qrSize - 8;
                    // Info box background
                    $pdf->SetFillColor(255, 255, 255);
                    $pdf->SetDrawColor(180, 150, 80);
                    $pdf->Rect($boxX, $boxY, $boxW, $boxH, 'DF');
                    // Info box: left English, right Arabic, center dynamic
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->SetTextColor(60, 60, 60);
                    $rowH = 4.5;
                    $labels = [
                        ['e-Verify No', 'رقم التصديق', $infoBox['verify_no'] ?? '-'],
                        ['Verify By', 'تم التحقق من قبل', $infoBox['verifier'] ?? '-'],
                        ['Verify at', 'تم التحقق في', $infoBox['verify_at'] ?? '-'],
                        ['Applicant Name', 'اسم العميل', $infoBox['name'] ?? '-'],
                        ['Document Name', 'اسم الوثيقة', $infoBox['document'] ?? '-'],
                        ['Date of Attestation', 'تاريخ التصديق', $infoBox['date'] ?? '-'],
                        ['Approver Name', 'تمت المصادقة من قبل', $infoBox['approver'] ?? '-'],
                    ];
                    $colW = ($boxW - 6) / 3;
                    $startY = $boxY + 3;
                    for ($i = 0; $i < count($labels); $i++) {
                        $y = $startY + $i * $rowH;
                        // Left: English
                        $pdf->SetXY($boxX + 3, $y);
                        $pdf->Cell($colW, $rowH, $labels[$i][0], 0, 0, 'L');
                        // Center: Data
                        $pdf->SetXY($boxX + 3 + $colW, $y);
                        $pdf->Cell($colW, $rowH, $labels[$i][2], 0, 0, 'C');
                        // Right: Arabic
                        $pdf->SetXY($boxX + 3 + 2 * $colW, $y);
                        $pdf->Cell($colW, $rowH, $labels[$i][1], 0, 0, 'R');
                    }
                    // QR code at bottom right
                    $pdf->Image($qrPath, $qrX, $qrY, $qrSize, $qrSize, 'PNG');
                }
            } elseif (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                // For images, always one page per image
                $tplIdx = $pdf->importPage(1);
                $pdf->AddPage();
                $pdf->useTemplate($tplIdx, 0, 0, 210, 297);
                // Place image in main content area (2/3 page, less top margin)
                $marginTop = 0; $marginLeft = 20; $contentW = 170; $contentH = 180;
                $pdf->Image($original, $marginLeft, $marginTop, $contentW, $contentH);
                // Draw info box and QR code at bottom as in screenshot
                $boxW = 120; $boxH = 28; $qrSize = 22;
                $boxX = 210 - $boxW - $qrSize - 12;
                $boxY = 297 - $boxH - 12;
                $qrX = 210 - $qrSize - 8;
                $qrY = 297 - $qrSize - 8;
                $pdf->SetFillColor(255, 255, 255);
                $pdf->SetDrawColor(180, 150, 80);
                $pdf->Rect($boxX, $boxY, $boxW, $boxH, 'DF');
                $pdf->SetFont('Arial', '', 8);
                $pdf->SetTextColor(60, 60, 60);
                $pdf->SetXY($boxX + 3, $boxY + 3);
                $pdf->MultiCell($boxW - 6, 4,
                    "e-Verify No: " . ($infoBox['verify_no'] ?? '-') . "\n" .
                    ($infoBox['verifier'] ? "Verify By: " . $infoBox['verifier'] . "\n" : "") .
                    ($infoBox['name'] ? "Applicant: " . $infoBox['name'] . "\n" : "") .
                    ($infoBox['document'] ? "Document: " . $infoBox['document'] . "\n" : "") .
                    ($infoBox['date'] ? "Date: " . $infoBox['date'] . "\n" : "") .
                    ($infoBox['approver'] ? "Approver: " . $infoBox['approver'] : "")
                );
                $pdf->Image($qrPath, $qrX, $qrY, $qrSize, $qrSize, 'PNG');
            }
        }
        $pdf->Output('F', $output);
        return $output;
    }
}
