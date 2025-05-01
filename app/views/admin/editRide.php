<?php
/**
 * Vue pour la modification d'un trajet (administrateur)
 */

// Démarrer la mise en tampon
ob_start();
?>

<div class="container">
    <h1 class="mb-4">Modifier un trajet</h1>
    
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Informations du trajet</h5>
        </div>
        <div class="card-body">
            <?php if (isset($errors['update'])): ?>
                <div class="alert alert-danger">
                    <?= $errors['update'] ?>
                </div>
            <?php endif; ?>
            
            <form method="post">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="departure_agency_id" class="form-label">Agence de départ</label>
                        <select class="form-select <?= isset($errors['departure_agency_id']) ? 'is-invalid' : '' ?>" id="departure_agency_id" name="departure_agency_id">
                            <option value="">Sélectionnez une agence</option>
                            <?php foreach ($agencies as $agency): ?>
                                <option value="<?= $agency['id'] ?>" <?= $departure_agency_id == $agency['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($agency['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['departure_agency_id'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['departure_agency_id'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="arrival_agency_id" class="form-label">Agence d'arrivée</label>
                        <select class="form-select <?= isset($errors['arrival_agency_id']) ? 'is-invalid' : '' ?>" id="arrival_agency_id" name="arrival_agency_id">
                            <option value="">Sélectionnez une agence</option>
                            <?php foreach ($agencies as $agency): ?>
                                <option value="<?= $agency['id'] ?>" <?= $arrival_agency_id == $agency['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($agency['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['arrival_agency_id'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['arrival_agency_id'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="departure_date" class="form-label">Date de départ</label>
                        <input type="date" class="form-control <?= isset($errors['departure_datetime']) ? 'is-invalid' : '' ?>" id="departure_date" name="departure_date" value="<?= $departure_date ?>">
                    </div>
                    
                    <div class="col-md-3">
                        <label for="departure_time" class="form-label">Heure de départ</label>
                        <input type="time" class="form-control <?= isset($errors['departure_datetime']) ? 'is-invalid' : '' ?>" id="departure_time" name="departure_time" value="<?= $departure_time ?>">
                        <?php if (isset($errors['departure_datetime'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['departure_datetime'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="arrival_date" class="form-label">Date d'arrivée</label>
                        <input type="date" class="form-control <?= isset($errors['arrival_datetime']) ? 'is-invalid' : '' ?>" id="arrival_date" name="arrival_date" value="<?= $arrival_date ?>">
                    </div>
                    
                    <div class="col-md-3">
                        <label for="arrival_time" class="form-label">Heure d'arrivée</label>
                        <input type="time" class="form-control <?= isset($errors['arrival_datetime']) ? 'is-invalid' : '' ?>" id="arrival_time" name="arrival_time" value="<?= $arrival_time ?>">
                        <?php if (isset($errors['arrival_datetime'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['arrival_datetime'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="total_seats" class="form-label">Nombre total de places</label>
                        <input type="number" class="form-control <?= isset($errors['total_seats']) ? 'is-invalid' : '' ?>" id="total_seats" name="total_seats" value="<?= $total_seats ?>">
                        <?php if (isset($errors['total_seats'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['total_seats'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="available_seats" class="form-label">Nombre de places disponibles</label>
                        <input type="number" class="form-control <?= isset($errors['available_seats']) ? 'is-invalid' : '' ?>" id="available_seats" name="available_seats" value="<?= $available_seats ?>">
                        <?php if (isset($errors['available_seats'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['available_seats'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Informations du conducteur</label>
                    <p class="form-control-static">
                        <?= htmlspecialchars($ride['firstname'] . ' ' . $ride['lastname']) ?> |
                        Email: <?= htmlspecialchars($ride['email']) ?>
                    </p>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="<?= BASE_URL ?>admin/rides" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Modifier le trajet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Récupérer le contenu mis en tampon
$content = ob_get_clean();

// Inclure le layout
require_once ROOT_PATH . '/app/views/layouts/default.php';
?> 