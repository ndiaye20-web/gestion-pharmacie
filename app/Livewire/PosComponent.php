<?php

namespace App\Livewire;

use App\Models\Medicament;
use App\Models\Patient;
use App\Models\Vente;
use App\Models\LigneVente;
use App\Models\Lot;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class PosComponent extends Component
{
    public $search = '';
    public $selectedMedicaments = [];
    public $patient_id = null;
    public $mode_paiement = 'Espèces';
    public $total = 0;
    public $quantities = [];
    public $patients = [];
    public $medicaments = [];

    public function mount()
    {
        $this->patients = Patient::orderBy('nom')->orderBy('prenom')->get();
        $this->medicaments = Medicament::with('lots')->orderBy('nom_commercial')->get();
    }

    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) {
            $this->medicaments = Medicament::where('nom_commercial', 'like', '%' . $this->search . '%')
                ->orWhere('code_cip13', 'like', '%' . $this->search . '%')
                ->with('lots')
                ->orderBy('nom_commercial')
                ->get();
        } else {
            $this->medicaments = Medicament::with('lots')->orderBy('nom_commercial')->get();
        }
    }

    public function addMedicament($medicamentId)
    {
        $medicament = Medicament::find($medicamentId);
        if (!$medicament) return;

        if (!isset($this->selectedMedicaments[$medicamentId])) {
            $this->selectedMedicaments[$medicamentId] = $medicament;
            $this->quantities[$medicamentId] = 1;
        } else {
            $this->quantities[$medicamentId]++;
        }

        $this->calculateTotal();
    }

    public function removeMedicament($medicamentId)
    {
        if (isset($this->selectedMedicaments[$medicamentId])) {
            unset($this->selectedMedicaments[$medicamentId]);
            unset($this->quantities[$medicamentId]);
        }

        $this->calculateTotal();
    }

    public function updateQuantity($medicamentId, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeMedicament($medicamentId);
            return;
        }

        $this->quantities[$medicamentId] = $quantity;
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = 0;
        foreach ($this->selectedMedicaments as $id => $medicament) {
            $this->total += $medicament->prix_vente * ($this->quantities[$id] ?? 0);
        }
    }

    public function scanCode($code)
    {
        $medicament = Medicament::where('code_cip13', $code)->first();

        if ($medicament) {
            $this->addMedicament($medicament->id);
            $this->dispatch('medicament-added', ['name' => $medicament->nom_commercial]);
        } else {
            $this->dispatch('medicament-not-found');
        }
    }

    public function processSale()
    {
        $this->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'mode_paiement' => 'required|string|max:50',
        ]);

        if (empty($this->selectedMedicaments)) {
            session()->flash('error', 'Veuillez sélectionner au moins un médicament.');
            return;
        }

        // Vérifier le stock
        foreach ($this->selectedMedicaments as $id => $medicament) {
            $quantity = $this->quantities[$id] ?? 0;
            $stockRestant = Lot::where('medicament_id', $id)->sum('quantite');

            if ($stockRestant < $quantity) {
                session()->flash('error', 'Stock insuffisant pour ' . $medicament->nom_commercial);
                return;
            }
        }

        // Créer la vente
        $vente = Vente::create([
            'patient_id' => $this->patient_id,
            'pharmacien_id' => Auth::id(),
            'mode_paiement' => $this->mode_paiement,
            'ticket_numero' => 'POS-' . now()->format('YmdHis') . '-' . Auth::id(),
            'date' => now(),
            'total' => $this->total,
        ]);

        // Traiter les lignes de vente
        foreach ($this->selectedMedicaments as $id => $medicament) {
            $quantity = $this->quantities[$id] ?? 0;
            $remaining = $quantity;

            // Réduire le stock par ordre de péremption
            while ($remaining > 0) {
                $lot = Lot::where('medicament_id', $id)
                    ->where('quantite', '>', 0)
                    ->orderBy('date_expiration', 'asc')
                    ->first();

                if (!$lot) break;

                $quantityToTake = min($remaining, $lot->quantite);
                $lot->decrement('quantite', $quantityToTake);
                $remaining -= $quantityToTake;
            }

            LigneVente::create([
                'vente_id' => $vente->id,
                'medicament_id' => $id,
                'quantite' => $quantity,
                'prix' => $medicament->prix_vente,
            ]);
        }

        // Réinitialiser le panier
        $this->selectedMedicaments = [];
        $this->quantities = [];
        $this->total = 0;
        $this->patient_id = null;
        $this->mode_paiement = 'Espèces';

        session()->flash('success', 'Vente enregistrée avec succès!');
        $this->dispatch('sale-completed', ['vente_id' => $vente->id]);
    }

    public function render()
    {
        return view('livewire.pos-component');
    }
}
